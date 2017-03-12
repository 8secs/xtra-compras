<?php

/* /var/www/public/themes/xtraice-theme/partials/common/preloader.htm */
class __TwigTemplate_e3a9dc2a01fd473c8b2497671f1f1dfc6629d6d8dcfb0452924d6835d1c45bf6 extends Twig_Template
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
        echo "<div class=\"preloader\"></div>";
    }

    public function getTemplateName()
    {
        return "/var/www/public/themes/xtraice-theme/partials/common/preloader.htm";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<div class=\"preloader\"></div>", "/var/www/public/themes/xtraice-theme/partials/common/preloader.htm", "");
    }
}
