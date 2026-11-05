<?php
/*
 * SeventeenPHP — 超轻量级 PHP 开发框架
 *
 * @author        哈尔滨伟成科技有限公司 (唐晓伟 QQ:77701950)
 * @copyright     Copyright (c) 2026 哈尔滨伟成科技有限公司
 * @license       Apache License 2.0（Apache 2.0 开源协议）
 *                本框架基于 Apache 2.0 协议开源，分发使用时必须保留上述版权声明。
 * @link          http://www.ourphp.net
 *
 */
namespace Seventeen;

use RuntimeException;

class ourphp_templates
{
    private $vars = [];
    private $tplDir;
    private $cacheDir;
    private $left  = '@{';
    private $right = '}';

    /** 已校验过的模板文件（省 realpath/is_file 开销） */
    private static $checked = [];
    /** 系统变量缓存 */
    private $sysVars = null;

    public function __construct($tplDir, $cacheDir = null, $left = '@{', $right = '}')
    {
        $this->tplDir   = rtrim($tplDir, '/\\') . DIRECTORY_SEPARATOR;
        $this->cacheDir = $cacheDir
            ? rtrim($cacheDir, '/\\') . DIRECTORY_SEPARATOR
            : $this->tplDir . 'cache' . DIRECTORY_SEPARATOR;
        $this->left  = (string)$left;
        $this->right = (string)$right;
        if (!is_dir($this->cacheDir) && !mkdir($this->cacheDir, 0755, true) && !is_dir($this->cacheDir)) {
            throw new RuntimeException('无法创建缓存目录: ' . $this->cacheDir);
        }
    }

    public function assign($name, $value = null)
    {
        if (is_array($name)) $this->vars = array_merge($this->vars, $name);
        else                 $this->vars[$name] = $value;
        return $this;
    }

    public function display($template, array $extra = [])
    {
        echo $this->fetch($template, $extra);
    }

    public function fetch($template, array $extra = [])
    {
        // 绝对路径直接用；相对路径拼 tplDir
        $tplFile = $this->isAbsolutePath($template) ? $template : $this->tplDir . $template;

        // 文件存在性只校验一次（同一请求内多次 include 时省 IO）
        if (!isset(self::$checked[$tplFile])) {
            if (!is_file($tplFile)) {
                throw new RuntimeException('模板不存在: ' . $tplFile);
            }
            $real = realpath($tplFile);
            if ($real !== false) $tplFile = $real;
            self::$checked[$tplFile] = true;
        }

        // 缓存走 cacheDir，key 用完整路径，不同模板不会撞
        $cacheFile = $this->cacheDir . md5($tplFile) . '.php';
        if (!is_file($cacheFile) || filemtime($cacheFile) < filemtime($tplFile)) {
            $this->compile($tplFile, $cacheFile);
        }
        return $this->render($cacheFile, $extra);
    }

    private function isAbsolutePath($path)
    {
        return $path !== '' && (
            $path[0] === '/' || $path[0] === '\\'
            || preg_match('/^[a-zA-Z]:[\\\\\/]/', $path)
        );
    }

    /* ================= 内部 ================= */

    private function compile($tplFile, $cacheFile)
    {
        $baseDir = dirname($tplFile);
        $content = $this->parse(file_get_contents($tplFile), $baseDir);

        // 直接写，不用 tmp + rename（Windows rename 覆盖可能失败，导致每次都重编译）
        if (file_put_contents($cacheFile, $content, LOCK_EX) === false) {
            throw new RuntimeException('写入编译文件失败: ' . $cacheFile);
        }
        @chmod($cacheFile, 0644);
    }

	private function render($__file, array $__extra = [])
	{
		if ($this->sysVars === null) {
			$this->sysVars = [
				'get' => $_GET, 'post' => $_POST, 'cookie' => $_COOKIE,
				'server' => $_SERVER, 'session' => isset($_SESSION) ? $_SESSION : [],
				'request' => array_merge($_GET, $_POST), 'env' => $_ENV, 'files' => $_FILES,
			];
		}
		$__vars = array_merge($this->sysVars, $this->vars, $__extra);

		foreach ([
			'this','template','extra','__vars','php','file','__cv','__k','__key',
			'__file','__extra',
		] as $__k) {
			unset($__vars[$__k]);
		}

		extract($__vars, EXTR_OVERWRITE);
		ob_start();
		include $__file;
		return ob_get_clean();
	}

    private function parse($content, $baseDir = '')
    {
        $L = preg_quote($this->left, '#');
        $R = preg_quote($this->right, '#');

        // 1. literal 保护
        $literals = [];
		$content = preg_replace_callback(
			'#' . $L . 'include\s+file\s*=\s*(["\'])([^"\']+)\1\s*' . $R . '#',
			function ($m) use ($baseDir) {
				$inc = $m[2];
				$incPath = $this->isAbsolutePath($inc)
					? $inc
					: rtrim($baseDir, '/\\') . DIRECTORY_SEPARATOR . $inc;
				return '<?php $__cv = get_defined_vars();'
					 . ' unset($__cv["this"],$__cv["template"],$__cv["extra"],$__cv["__vars"],'
					 . '$__cv["php"],$__cv["file"],$__cv["__cv"],$__cv["__k"],$__cv["__key"],'
					 . '$__cv["__file"],$__cv["__extra"]);'
					 . ' echo $this->fetch(' . var_export($incPath, true) . ', $__cv); ?>';
			},
			$content
		);

        // 2. 注释
        $content = preg_replace('#' . $L . '\*.*?\*' . $R . '#s', '', $content);

        // 3. include（以当前模板目录 $baseDir 为基准；绝对路径直接用）
        $content = preg_replace_callback(
            '#' . $L . 'include\s+file\s*=\s*(["\'])([^"\']+)\1\s*' . $R . '#',
            function ($m) use ($baseDir) {
                $inc = $m[2];
                $incPath = $this->isAbsolutePath($inc)
                    ? $inc
                    : rtrim($baseDir, '/\\') . DIRECTORY_SEPARATOR . $inc;
                return '<?php $__cv = get_defined_vars();'
                     . ' unset($__cv["this"],$__cv["template"],$__cv["extra"],$__cv["__vars"],'
                     . '$__cv["php"],$__cv["file"],$__cv["__cv"],$__cv["__k"],$__cv["__key"]);'
                     . ' echo $this->fetch(' . var_export($incPath, true) . ', $__cv); ?>';
            },
            $content
        );

        // 4. foreach
        $content = preg_replace_callback(
            '#' . $L . 'foreach\s+(.+?)' . $R . '#',
            function ($m) {
                $expr = trim($m[1]);
                if (preg_match('/^(.+?)\s+as\s+(.+)$/i', $expr, $parts)) {
                    return '<?php foreach((array)(' . $this->dot2array(trim($parts[1]), true) . ') as ' . trim($parts[2]) . '): ?>';
                }
                return '<?php foreach((array)(' . $this->dot2array($expr, true) . ')): ?>';
            },
            $content
        );
        $content = str_replace($this->left . '/foreach' . $this->right, '<?php endforeach; ?>', $content);

        // 5. if / elseif / else
        $content = preg_replace_callback(
            '#' . $L . 'if\s+(.+?)' . $R . '#',
            function ($m) {
                return '<?php if(' . $this->dot2array(trim($m[1])) . '): ?>';
            },
            $content
        );
        $content = preg_replace_callback(
            '#' . $L . 'elseif\s+(.+?)' . $R . '#',
            function ($m) {
                return '<?php elseif(' . $this->dot2array(trim($m[1])) . '): ?>';
            },
            $content
        );
        $content = str_replace($this->left . 'else' . $this->right, '<?php else: ?>', $content);
        $content = str_replace($this->left . '/if' . $this->right, '<?php endif; ?>', $content);

        // 6. 变量输出
        $content = preg_replace_callback(
            '#' . $L . '\$(.+?)' . $R . '#',
            function ($m) {
                return '<?php echo ' . $this->parseVar(trim($m[1])) . '; ?>';
            },
            $content
        );

        // 7. 还原 literal
        foreach ($literals as $k => $v) $content = str_replace($k, $v, $content);

        return $content;
    }

    /**
     * $a.b.c → ($a['b']['c'] ?? null)
     * $a     → $a（单级默认不兜底；$singleSafe=true 时 → ($a ?? null)）
     * 多级自动加 ?? null，防未定义 key 警告（GET/POST/SERVER 常用）
     */
    private function dot2array($expr, $singleSafe = false)
    {
        return preg_replace_callback('/\$([a-zA-Z_][a-zA-Z0-9_]*)((?:\.[a-zA-Z0-9_]+)*)/', function ($m) use ($singleSafe) {
            $out = '$' . $m[1];
            if (!empty($m[2])) {
                foreach (explode('.', substr($m[2], 1)) as $p) {
                    $out .= is_numeric($p) ? "[$p]" : "['$p']";
                }
                return '(' . $out . ' ?? null)';
            }
            return $singleSafe ? '(' . $out . ' ?? null)' : $out;
        }, $expr);
    }

    private function parseVar($str)
    {
        $parts = explode('|', $str);
        $expr  = $this->buildVar(array_shift($parts));

        foreach ($parts as $mod) {
            $mod = trim($mod);
            if ($mod === '') continue;
            $argStr = '';
            if (strpos($mod, ':') !== false) {
                list($mod, $argStr) = explode(':', $mod, 2);
                $mod = trim($mod);
            }
            $args = [];
            if ($argStr !== '') {
                foreach (explode(',', $argStr) as $a) {
                    $a = trim($a);
                    if ($a === '') continue;
                    if (preg_match('/^(["\']).*\1$/', $a))   $args[] = $a;
                    elseif (is_numeric($a))                  $args[] = $a;
                    elseif ($a[0] === '$')                   $args[] = $this->buildVar(substr($a, 1));
                    else                                     $args[] = var_export($a, true);
                }
            }
            $argList = $args ? ',' . implode(',', $args) : '';
            switch ($mod) {
                case 'escape':  $expr = 'htmlspecialchars((string)(' . $expr . '), ENT_QUOTES, "UTF-8")'; break;
                case 'nl2br':   $expr = 'nl2br((string)(' . $expr . '))'; break;
                case 'upper':   $expr = 'mb_strtoupper((string)(' . $expr . '), "UTF-8")'; break;
                case 'lower':   $expr = 'mb_strtolower((string)(' . $expr . '), "UTF-8")'; break;
                case 'date':    $fmt = $args ? $args[0] : '"Y-m-d H:i:s"';
                                $expr = 'date(' . $fmt . ', (int)(' . $expr . '))'; break;
                case 'default': $dft = $args ? $args[0] : '""';
                                $expr = '((' . $expr . ') !== null && (' . $expr . ') !== "" ? (' . $expr . ') : ' . $dft . ')'; break;
                default:
                    if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $mod)) {
                        $expr = $mod . '(' . $expr . $argList . ')';
                    }
            }
        }
        return $expr;
    }

    private function buildVar($str)
    {
        $str = trim($str);
        if ($str === '') return '""';
        if ($str[0] === '$') return $this->dot2array($str);
        if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $str)) return '$' . $str;
        return $this->dot2array('$' . $str);
    }
}
?>