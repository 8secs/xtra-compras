<?php

/* /var/www/public/themes/xtraice-theme/partials/common/meta.htm */
class __TwigTemplate_ec78752554b10bc911e0ccc4b7dcf98d9e2d3069a542aeb835a65acd4c37cb99 extends Twig_Template
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
        echo "<meta charset=\"UTF-8\">
<meta name=\"Description\" content=\"";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "description", array()), "html", null, true);
        echo "\"/>
<meta name=\"Keywords\" content=\"";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "keywords", array()), "html", null, true);
        echo "\"/>
<title>IsTheweb - ";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "page", array()), "title", array()), "html", null, true);
        echo "</title>
<meta name=\"author\" content=\"YavaDava\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
<link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"";
        // line 7
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-57x57.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"60x60\" href=\"";
        // line 8
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-60x60.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"";
        // line 9
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-72x72.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"76x76\" href=\"";
        // line 10
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-76x76.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"";
        // line 11
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-114x114.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"";
        // line 12
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-120x120.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"";
        // line 13
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-144x144.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"";
        // line 14
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-152x152.png");
        echo "\">
<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"";
        // line 15
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/apple-icon-180x180.png");
        echo "\">
<link rel=\"icon\" type=\"image/png\" sizes=\"192x192\"  href=\"";
        // line 16
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/android-icon-192x192.png");
        echo "\">
<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"";
        // line 17
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/favicon-32x32.png");
        echo "\">
<link rel=\"icon\" type=\"image/png\" sizes=\"96x96\" href=\"";
        // line 18
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/favicon-96x96.png");
        echo "\">
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"";
        // line 19
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/favicon-16x16.png");
        echo "\">
<link rel=\"manifest\" href=\"";
        // line 20
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/manifest.json");
        echo "\">
<meta name=\"msapplication-TileColor\" content=\"#ffffff\">
<meta name=\"msapplication-TileImage\" content=\"";
        // line 22
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter("assets/images/favicon/ms-icon-144x144.png");
        echo "\">

<meta name=\"twitter:widgets:theme\" content=\"light\">
<meta name=\"twitter:widgets:link-color\" content=\"#55acee\">
<meta name=\"twitter:widgets:border-color\" content=\"#55acee\">

<!-- Responsivity for older IE -->
<!--[if lt IE 9]>
<script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
<![endif]-->
<meta name=\"generator\" content=\"YavaDav Platform\" />
";
        // line 34
        echo $this->env->getExtension('CMS')->assetsFunction('css');
        echo $this->env->getExtension('CMS')->displayBlock('styles');
        // line 35
        echo "<link href=\"";
        echo $this->env->getExtension('Cms\Twig\Extension')->themeFilter(array(0 => "node_modules/owl-carousel-2-beta/dist/assets/owl.carousel.min.css", 1 => "node_modules/owl-carousel-2-beta/dist/assets/owl.theme.default.min.css", 2 => "assets/vendor/magic-popup/dist/magnific-popup.css", 3 => "node_modules/animate.css/animate.min.css", 4 => "assets/vendor/themify-icons/css/themify-icons.css", 5 => "node_modules/jquery-toast-plugin/dist/jquery.toast.min.css", 6 => "assets/vendor/meanMenu/meanmenu.min.css", 7 => "assets/vendor/noUiSlider/nouislider.min.css", 8 => "assets/css/theme.css"));
        // line 45
        echo "\" rel=\"stylesheet\">";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/common/meta.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  114 => 45,  111 => 35,  108 => 34,  93 => 22,  88 => 20,  84 => 19,  80 => 18,  76 => 17,  72 => 16,  68 => 15,  64 => 14,  60 => 13,  56 => 12,  52 => 11,  48 => 10,  44 => 9,  40 => 8,  36 => 7,  30 => 4,  26 => 3,  22 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<meta charset=\"UTF-8\">
<meta name=\"Description\" content=\"{{ page.description }}\"/>
<meta name=\"Keywords\" content=\"{{ page.keywords }}\"/>
<title>IsTheweb - {{ this.page.title }}</title>
<meta name=\"author\" content=\"YavaDava\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
<link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"{{ 'assets/images/favicon/apple-icon-57x57.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"60x60\" href=\"{{ 'assets/images/favicon/apple-icon-60x60.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"{{ 'assets/images/favicon/apple-icon-72x72.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"76x76\" href=\"{{ 'assets/images/favicon/apple-icon-76x76.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"{{ 'assets/images/favicon/apple-icon-114x114.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"{{ 'assets/images/favicon/apple-icon-120x120.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"{{ 'assets/images/favicon/apple-icon-144x144.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"{{ 'assets/images/favicon/apple-icon-152x152.png'|theme }}\">
<link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"{{ 'assets/images/favicon/apple-icon-180x180.png'|theme }}\">
<link rel=\"icon\" type=\"image/png\" sizes=\"192x192\"  href=\"{{ 'assets/images/favicon/android-icon-192x192.png'|theme }}\">
<link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"{{ 'assets/images/favicon/favicon-32x32.png'|theme }}\">
<link rel=\"icon\" type=\"image/png\" sizes=\"96x96\" href=\"{{ 'assets/images/favicon/favicon-96x96.png'|theme }}\">
<link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"{{ 'assets/images/favicon/favicon-16x16.png'|theme }}\">
<link rel=\"manifest\" href=\"{{ 'assets/images/favicon/manifest.json'|theme }}\">
<meta name=\"msapplication-TileColor\" content=\"#ffffff\">
<meta name=\"msapplication-TileImage\" content=\"{{ 'assets/images/favicon/ms-icon-144x144.png'|theme }}\">

<meta name=\"twitter:widgets:theme\" content=\"light\">
<meta name=\"twitter:widgets:link-color\" content=\"#55acee\">
<meta name=\"twitter:widgets:border-color\" content=\"#55acee\">

<!-- Responsivity for older IE -->
<!--[if lt IE 9]>
<script src=\"https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js\"></script>
<script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>
<![endif]-->
<meta name=\"generator\" content=\"YavaDav Platform\" />
{% styles %}
<link href=\"{{ [
            'node_modules/owl-carousel-2-beta/dist/assets/owl.carousel.min.css',
            'node_modules/owl-carousel-2-beta/dist/assets/owl.theme.default.min.css',
            'assets/vendor/magic-popup/dist/magnific-popup.css',
            'node_modules/animate.css/animate.min.css',
            'assets/vendor/themify-icons/css/themify-icons.css',
            'node_modules/jquery-toast-plugin/dist/jquery.toast.min.css',
            'assets/vendor/meanMenu/meanmenu.min.css',
            'assets/vendor/noUiSlider/nouislider.min.css',
            'assets/css/theme.css',
        ]|theme }}\" rel=\"stylesheet\">", "/var/www/public/themes/xtraice-theme/partials/common/meta.htm", "");
    }
}
