<?php

/* /var/www/public/themes/xtraice-theme/layouts/default.htm */
class __TwigTemplate_0f4bd53b7b515ef1da1286429ca1ea71f0b662665bab4e957d08e5a05eb5a0d4 extends Twig_Template
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
        echo "<!DOCTYPE html>
<html>
<head>
    ";
        // line 4
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("common/meta"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 5
        echo "</head>
<body>

";
        // line 8
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("common/preloader"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 9
        echo "
<div id=\"wrapper\" class=\"page-wrap\">
    <header id=\"header\" class=\"header\">

        ";
        // line 13
        $context['__cms_partial_params'] = [];
        $context['__cms_partial_params']['layout'] = $this->getAttribute($this->getAttribute((isset($context["this"]) ? $context["this"] : null), "param", array()), "from", array())        ;
        echo $this->env->getExtension('CMS')->partialFunction("header/header"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 14
        echo "
    </header>

    <!-- START main wrapper section -->
    <section>
        ";
        // line 19
        echo $this->env->getExtension('CMS')->pageFunction();
        // line 20
        echo "    </section>
    <!--/ END main wrapper section -->

    <footer id=\"footer\" class=\"footer content-block\">
        ";
        // line 24
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("common/footer"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 25
        echo "    </footer>

    ";
        // line 27
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("common/footer-bottom"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 28
        echo "
</div>

";
        // line 31
        $context['__cms_partial_params'] = [];
        echo $this->env->getExtension('CMS')->partialFunction("common/scripts"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 32
        echo "</body>
</html>";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/layouts/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 32,  80 => 31,  75 => 28,  71 => 27,  67 => 25,  63 => 24,  57 => 20,  55 => 19,  48 => 14,  43 => 13,  37 => 9,  33 => 8,  28 => 5,  24 => 4,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
    {% partial 'common/meta' %}
</head>
<body>

{% partial 'common/preloader' %}

<div id=\"wrapper\" class=\"page-wrap\">
    <header id=\"header\" class=\"header\">

        {% partial 'header/header' layout=this.param.from %}

    </header>

    <!-- START main wrapper section -->
    <section>
        {% page %}
    </section>
    <!--/ END main wrapper section -->

    <footer id=\"footer\" class=\"footer content-block\">
        {% partial 'common/footer' %}
    </footer>

    {% partial 'common/footer-bottom' %}

</div>

{% partial 'common/scripts' %}
</body>
</html>", "/var/www/public/themes/xtraice-theme/layouts/default.htm", "");
    }
}
