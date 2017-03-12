<?php

/* /var/www/public/themes/xtraice-theme/partials/header/header.htm */
class __TwigTemplate_4f6fc41a85e5bc69a077f459e8079a733f97061f06286b6f4a4b5c8751df5cfa extends Twig_Template
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
        if (((isset($context["layout"]) ? $context["layout"] : null) != "landing")) {
            // line 2
            echo "<div class=\"header-top\">
    ";
            // line 3
            $context['__cms_partial_params'] = [];
            $context['__cms_partial_params']['layout'] = (isset($context["layout"]) ? $context["layout"] : null)            ;
            echo $this->env->getExtension('CMS')->partialFunction("header/header-top"            , $context['__cms_partial_params']            );
            unset($context['__cms_partial_params']);
            // line 4
            echo "</div>
";
        }
        // line 6
        echo "<div class=\"header-bottom\">
    ";
        // line 7
        $context['__cms_partial_params'] = [];
        $context['__cms_partial_params']['layout'] = (isset($context["layout"]) ? $context["layout"] : null)        ;
        echo $this->env->getExtension('CMS')->partialFunction("header/header-bottom"        , $context['__cms_partial_params']        );
        unset($context['__cms_partial_params']);
        // line 8
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/header/header.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 8,  36 => 7,  33 => 6,  29 => 4,  24 => 3,  21 => 2,  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% if layout != 'landing' %}
<div class=\"header-top\">
    {% partial 'header/header-top' layout=layout %}
</div>
{% endif %}
<div class=\"header-bottom\">
    {% partial 'header/header-bottom' layout=layout %}
</div>", "/var/www/public/themes/xtraice-theme/partials/header/header.htm", "");
    }
}
