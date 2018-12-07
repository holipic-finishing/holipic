<?php

    function styles(array $styles)
    {
        foreach ($styles as $style) {
            if (env('USE_LESS_ON_LOCAL', true)) {
                $rel = preg_match('/.less$/', $style) ? 'stylesheet/less' : 'stylesheet';
            } else {
                $rel = 'stylesheet';
                $style = preg_replace("/.less$/", '.css', $style);
            }

            if (preg_match("/(^http\:\/\/)|(^https\:\/\/)/", $style)) {
                echo "<link href='$style' rel='$rel' type='text/css'>\n";
            } else {
                echo "<link href='" . url($style) . "' rel='$rel' type='text/css'>\n";
            }
        }
    }

    function scripts(array $scripts)
    {
        foreach ($scripts as $script) {
            if (preg_match("/(^http\:\/\/)|(^https\:\/\/)/", $script)) {
                echo '<script type="text/javascript" src="' . $script . '"></script>' . "\n";
            } else {
                echo '<script type="text/javascript" src="' . url($script) . '"></script>' . "\n";
            }
        }
    }

