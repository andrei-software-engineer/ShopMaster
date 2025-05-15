<?php

use Illuminate\Support\Str;

use App\Models\Base\Config;
use App\Models\Base\DT;
use App\Models\Base\Label;

if (!function_exists('_GL')) { function _GL($key) { return Label::GL($key); } }
if (!function_exists('_GLS')) { function _GLS($key) { return Label::GLS($key); } }
if (!function_exists('_GLA')) { function _GLA($key) { return Label::GLA($key); } }
if (!function_exists('_GLM')) { function _GLM($key) { return Label::GLM($key); } }
if (!function_exists('_GLAPI')) { function _GLAPI($key) { return Label::GLAPI($key); } }
if (!function_exists('_GDTT')) { function _GDTT($key) { return DT::GDT_T_FRONT($key); } }

if (!function_exists('_CGC')) { function _CGC($key) { return Config::CGC($key); } }

if (!function_exists('supportsWebp')) {
    function supportsWebp() {
        return Str::contains($_SERVER['HTTP_USER_AGENT'], ['Trident','Safari',]) ? false : true;

    }
}