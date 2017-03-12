<?php

/* /var/www/public/themes/xtraice-theme/partials/common/scripts.htm */
class __TwigTemplate_fde9d938a0083bfc84866392b4a001f12cc50466003b4ba1cc9c0b59d3da5fdf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!-- Scripts -->
<!--<script src=\"https://www.atlasestateagents.co.uk/javascript/tether.min.js\"></script> Tether for Bootstrap -->
";
        // line 3
        $context['__cms_component_params'] = [];
        echo $this->env->getExtension('CMS')->componentFunction("googleTracker"        , $context['__cms_component_params']        );
        unset($context['__cms_component_params']);
        // line 4
        echo "<script src=\"";
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter(array(0 => "assets/js/jquery.js", 1 => "node_modules/tether/dist/js/tether.min.js", 2 => "assets/js/bootstrap.min.js", 3 => "assets/vendor/bootstrap/js/alert.js", 4 => "node_modules/jquery.easing/jquery.easing.min.js", 5 => "node_modules/owl-carousel-2-beta/dist/owl.carousel.min.js", 6 => "assets/vendor/magic-popup/dist/jquery.magnific-popup.min.js", 7 => "node_modules/jquery-sticky/jquery.sticky.js", 8 => "node_modules/wowjs/dist/wow.min.js", 9 => "node_modules/jquery-toast-plugin/dist/jquery.toast.min.js", 10 => "assets/vendor/meanMenu/jquery.meanmenu.min.js", 11 => "assets/vendor/noUiSlider/nouislider.min.js", 12 => "assets/vendor/elevatezoom/jquery.elevateZoom-3.0.8.min.js", 13 => "assets/js/jquery.treeview.js", 14 => "assets/js/bootstrap.min.js", 15 => "assets/js/app.js"));
        // line 21
        echo "\"></script>

<script type=\"text/javascript\" src=\"https://js.stripe.com/v2/\"></script>

<script src=\"https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js\"></script>

";
        // line 27
        echo '<script src="'. Request::getBasePath()
                .'/modules/system/assets/js/framework.js"></script>'.PHP_EOL;
        echo '<script src="'. Request::getBasePath()
                    .'/modules/system/assets/js/framework.extras.js"></script>'.PHP_EOL;
        echo '<link rel="stylesheet" property="stylesheet" href="'. Request::getBasePath()
                    .'/modules/system/assets/css/framework.extras.css">'.PHP_EOL;
        // line 28
        echo $this->env->getExtension('CMS')->assetsFunction('js');
        echo $this->env->getExtension('CMS')->displayBlock('scripts');
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/common/scripts.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 28,  38 => 27,  30 => 21,  27 => 4,  23 => 3,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!-- Scripts -->
<!--<script src=\"https://www.atlasestateagents.co.uk/javascript/tether.min.js\"></script> Tether for Bootstrap -->
{% component 'googleTracker' %}
<script src=\"{{ [
    'assets/js/jquery.js',
    'node_modules/tether/dist/js/tether.min.js',
    'assets/js/bootstrap.min.js',
    'assets/vendor/bootstrap/js/alert.js',
    'node_modules/jquery.easing/jquery.easing.min.js',
    'node_modules/owl-carousel-2-beta/dist/owl.carousel.min.js',
    'assets/vendor/magic-popup/dist/jquery.magnific-popup.min.js',
    'node_modules/jquery-sticky/jquery.sticky.js',
    'node_modules/wowjs/dist/wow.min.js',
    'node_modules/jquery-toast-plugin/dist/jquery.toast.min.js',
    'assets/vendor/meanMenu/jquery.meanmenu.min.js',
    'assets/vendor/noUiSlider/nouislider.min.js',
    'assets/vendor/elevatezoom/jquery.elevateZoom-3.0.8.min.js',
    'assets/js/jquery.treeview.js',
    'assets/js/bootstrap.min.js',
    'assets/js/app.js'
]|theme }}\"></script>

<script type=\"text/javascript\" src=\"https://js.stripe.com/v2/\"></script>

<script src=\"https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js\"></script>

{% framework extras %}
{% scripts %}", "/var/www/public/themes/xtraice-theme/partials/common/scripts.htm", "");
    }
}
