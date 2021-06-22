<?php

/* TEMPLATE_ PREFILTER : ADJUSTPATH (2004-05-06) */

function adjustPath($source, &$tpl, $indicator='', $type='absolute')
{

	$default_indicator = 'css,js,gif,jpg,jpeg,png,swf';
	$path_filter = array();

//
	//$document_root = $_SERVER['DOCUMENT_ROOT']; 

	if (!$indicator || $indicator==='default') $indicator=$default_indicator;
	if (!$indicator=str_replace(',', '|', preg_replace('/^,\s*|\s*,$/', '', $indicator))) return $source;

	$web_path=$_SERVER['PHP_SELF'];
	$tpl_path=$tpl->tpl_path;
	$on_ms   =$tpl->on_ms;
	if (!empty($_SERVER['PATH_TRANSLATED'])) {
		$php_path=$_SERVER['PATH_TRANSLATED'];
	} elseif (!empty($_SERVER['SCRIPT_FILENAME'])) {
		$php_path=$_SERVER['SCRIPT_FILENAME'];
	} else {
		$tpl->report('Error #33', 'prefilter "adjustPath" cannot find absolute path of <b>'.$_SERVER['PHP_SELF'].' on OS</b>', true);
		exit;
	}
	if ($on_ms) {
		$web_path=preg_replace('@\\\\+@', '/', $web_path);
		$php_path=preg_replace('@\\\\+@', '/', $php_path);
		$tpl_path=preg_replace('@\\\\+@', '/', $tpl_path);
	}
	$web_dirs=explode('/', $web_path);
	$php_dirs=explode('/', $php_path);
	$tpl_dirs=explode('/', $tpl_path);
	array_pop($web_dirs);
	array_pop($php_dirs);
	array_pop($tpl_dirs);
	$web_depth=count($web_dirs);
	$php_depth=count($php_dirs);
	$tpl_depth=count($tpl_dirs);
	$m=array();

//
	$Dot='(?<=url\()\\\\*\./(?:(?:[^)/]+/)*[^)/]+)?'.
		'|(?<=")\\\\*\./(?:(?:[^"/]+/)*[^"/]+)?'.
		"|(?<=')\\\\*\./(?:(?:[^'/]+/)*[^'/]+)?";
	$Ext= $indicator[0]==='.' ? substr($indicator,2) : $indicator;
	$Ext='(?<=url\()(?:[^"\')/]+/)*[^"\')/]+\.(?:'.$Ext.')(?=\))'.
		'|(?<=")(?:[^"/]+/)*[^"/]+\.(?:'.$Ext.')(?=")'.
		"|(?<=')(?:[^'/]+/)*[^'/]+\.(?:".$Ext.")(?=')".
		'|(?<=\\\\")(?:[^"/]+/)*[^"/]+\.(?:'.$Ext.')(?=\\\\")'.
		"|(?<=\\\\')(?:[^'/]+/)*[^'/]+\.(?:".$Ext.")(?=\\\\')";
	if ($indicator==='.') $pattern=$Dot;
	else $pattern= $indicator[0]==='.' ? $Ext.'|'.$Dot : $Ext;
	$pattern='@('.$pattern.')@ix';
	$split=preg_split($pattern, $source, -1, PREG_SPLIT_DELIM_CAPTURE);

// to relative path

	if ($type==='relative') {
		$less_depth=$php_depth<$tpl_depth ? $php_depth : $tpl_depth;
		for ($i=0; $i<$less_depth; $i++) {
			if ($php_dirs[$i]!=$tpl_dirs[$i]) break;
		}
		$rel_path_pfx = $php_depth>$i ? str_repeat('../',$php_depth-$i) : '';
		if ($tpl_depth>$i) {
			$reducible = $tpl_depth - $i;
			$rel_path_pfx.=implode('/',array_slice($tpl_dirs, $i)).'/';
		} else {
			$reducible = 0;
		}
		for ($i=1,$s=count($split); $i<$s; $i+=2) {
			if (substr($split[$i], 0, 1)==='\\') {
				$split[$i]=substr($split[$i],1);
				continue;
			}
			$split[$i] = preg_replace('@^(\./)+@','',$split[$i]);
			if ($reducible && preg_match('@^((?:\.{2}/)+)@', $split[$i], $m)) {
				$reduce = substr_count($m[1], '../');
				if ($reduce > $reducible) $reduce = $reducible;
				$split[$i] = preg_replace('@(?:[^/]+/){'.$reduce.'}$@', '', $rel_path_pfx) . preg_replace('@^(\.{2}/){'.$reduce.'}@','',$split[$i]);
			} else {
				$split[$i] = $rel_path_pfx . $split[$i];
			}
		}
		return implode('', $split);
	}

// to absolute path


	$path_search =array_keys($path_filter);
	$path_replace=array_values($path_filter);
	if (empty($document_root)) {


		if ($web_depth===1) {
			$base_path=implode('/', $php_dirs);
		} else {
			$less_depth=($web_depth<$php_depth ? $web_depth : $php_depth)-1;
				
			$web_test=array_reverse($web_dirs);
			$php_test=array_reverse($php_dirs);


			for ($i=0; $i<$less_depth; $i++) {
				if ($web_test[$i]!=$php_test[$i]) break;
			}

			$base_path=implode('/', $i ? array_slice($php_dirs, 0, -$i) : $php_dirs);
			if ($i<$web_depth-1) {
				array_unshift($path_search, '/^/');
				array_unshift($path_replace, implode('/', $i ? array_slice($web_dirs, 0, -$i) : $web_dirs));
			}
		}
		$base_length =strlen($base_path);
	} else {
		if ($on_ms) $document_root=preg_replace('@\\\\+@', '/', $document_root);
		$base_length =strlen($document_root);
		if ($on_ms && strtolower(substr($tpl_path, 0, $base_length))!==strtolower($document_root)
			|| !$on_ms && substr($tpl_path, 0, $base_length)!==$document_root) {
			$tpl->report('Error #34', '"adjustPath" : template file <b>'.$tpl_path.'</b> is not in document root(<b>'.$document_root.'</b>)\'s sub directory', true);
			$tpl->exit_();
		}
	}
	$abs_path_pfx=preg_replace('@[^/]+$@', '', $tpl_path);
	for ($i=1,$s=count($split); $i<$s; $i+=2) {
		if (substr($split[$i], 0, 1)==='\\') {
			$split[$i]=substr($split[$i],1);
			continue;
		}
		if (!$src=realpath($abs_path_pfx.$split[$i])) {
			if (preg_match('@^((?:\.{1,2}/)+)@', $split[$i], $m)) {
				$src=preg_replace('@(?:[^/]+/){'.substr_count($m[1],'../').'}$@', '', $abs_path_pfx)
					.preg_replace('@^(\.{1,2}/)+@','',$split[$i]);
			} else {
				$src=$abs_path_pfx . $split[$i];
			}
		}
		if ($on_ms) $src = preg_replace('@\\\\+@', '/', $src);
		$split[$i]=substr($src, $base_length);
		if ($path_search) $split[$i]=preg_replace($path_search, $path_replace, $split[$i]);
	}
	return implode('', $split);
}
?>