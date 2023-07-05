<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* ux/_header.html.twig */
class __TwigTemplate_7c76eed1182a9d1a44388ca1bdf195e1 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "ux/_header.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "ux/_header.html.twig"));

        // line 1
        echo "<header class=\"bg-white mb-5\">
    <nav class=\"mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8\" aria-label=\"Global\">
        <div class=\"flex lg:flex-1\">
            <a href=\"#\" class=\"-m-1.5 p-1.5\">
                <span class=\"sr-only\">?</span>
                <img class=\"h-8 w-auto\" src=\"https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600\" alt=\"\">
            </a>
        </div>
        <div class=\"flex lg:hidden\">
            <button type=\"button\" class=\"-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700\">
                <span class=\"sr-only\">Open main menu</span>
                <svg class=\"h-6 w-6\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" aria-hidden=\"true\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5\" />
                </svg>
            </button>
        </div>
        <div class=\"hidden lg:flex lg:gap-x-12\">
            <a href=\"";
        // line 18
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_team_index");
        echo "\" class=\"text-sm font-semibold leading-6 text-gray-900\">Teams</a>
            <a href=\"";
        // line 19
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_standing_index");
        echo "\" class=\"text-sm font-semibold leading-6 text-gray-900\">Standings</a>
            <a href=\"";
        // line 20
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_country_index");
        echo "\" class=\"text-sm font-semibold leading-6 text-gray-900\">Countries</a>
            <a href=\"";
        // line 21
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_league_index");
        echo "\" class=\"text-sm font-semibold leading-6 text-gray-900\">Leagues</a>
            <a href=\"";
        // line 22
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_sport_index");
        echo "\" class=\"text-sm font-semibold leading-6 text-gray-900\">Sports</a>
        </div>
        <div class=\"hidden lg:flex lg:flex-1 lg:justify-end\">
            <a href=\"";
        // line 25
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_logout");
        echo "\" class=\"text-sm font-semibold leading-6 text-gray-900\">Logout</a>
        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class=\"lg:hidden\" role=\"dialog\" aria-modal=\"true\">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class=\"fixed inset-0 z-10\"></div>
        <div class=\"fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10\">
            <div class=\"flex items-center justify-between\">
                <a href=\"#\" class=\"-m-1.5 p-1.5\">
                    <span class=\"sr-only\">Your Company</span>
                    <img class=\"h-8 w-auto\" src=\"https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600\" alt=\"\">
                </a>
                <button type=\"button\" class=\"-m-2.5 rounded-md p-2.5 text-gray-700\">
                    <span class=\"sr-only\">Close menu</span>
                    <svg class=\"h-6 w-6\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" aria-hidden=\"true\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 18L18 6M6 6l12 12\" />
                    </svg>
                </button>
            </div>
            <div class=\"mt-6 flow-root\">
                <div class=\"-my-6 divide-y divide-gray-500/10\">
                    <div class=\"space-y-2 py-6\">
                        <div class=\"-mx-3\">
                            <button type=\"button\" class=\"flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50\" aria-controls=\"disclosure-1\" aria-expanded=\"false\">
                                Product
                                <!--
                                  Expand/collapse icon, toggle classes based on menu open state.

                                  Open: \"rotate-180\", Closed: \"\"
                                -->
                                <svg class=\"h-5 w-5 flex-none\" viewBox=\"0 0 20 20\" fill=\"currentColor\" aria-hidden=\"true\">
                                    <path fill-rule=\"evenodd\" d=\"M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z\" clip-rule=\"evenodd\" />
                                </svg>
                            </button>
                            <!-- 'Product' sub-menu, show/hide based on menu state. -->
                            <div class=\"mt-2 space-y-2\" id=\"disclosure-1\">
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Analytics</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Engagement</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Security</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Integrations</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Automations</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Watch demo</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Contact sales</a>
                            </div>
                        </div>
                        <a href=\"";
        // line 71
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_team_index");
        echo "\" class=\"-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Teams</a>
                        <a href=\"#\" class=\"-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Marketplace</a>
                        <a href=\"#\" class=\"-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Company</a>
                    </div>
                    <div class=\"py-6\">
                        <a href=\"";
        // line 76
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_logout");
        echo "\" class=\"-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    public function getTemplateName()
    {
        return "ux/_header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  141 => 76,  133 => 71,  84 => 25,  78 => 22,  74 => 21,  70 => 20,  66 => 19,  62 => 18,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<header class=\"bg-white mb-5\">
    <nav class=\"mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8\" aria-label=\"Global\">
        <div class=\"flex lg:flex-1\">
            <a href=\"#\" class=\"-m-1.5 p-1.5\">
                <span class=\"sr-only\">?</span>
                <img class=\"h-8 w-auto\" src=\"https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600\" alt=\"\">
            </a>
        </div>
        <div class=\"flex lg:hidden\">
            <button type=\"button\" class=\"-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700\">
                <span class=\"sr-only\">Open main menu</span>
                <svg class=\"h-6 w-6\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" aria-hidden=\"true\">
                    <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5\" />
                </svg>
            </button>
        </div>
        <div class=\"hidden lg:flex lg:gap-x-12\">
            <a href=\"{{ path('app_team_index') }}\" class=\"text-sm font-semibold leading-6 text-gray-900\">Teams</a>
            <a href=\"{{ path('app_standing_index') }}\" class=\"text-sm font-semibold leading-6 text-gray-900\">Standings</a>
            <a href=\"{{ path('app_country_index') }}\" class=\"text-sm font-semibold leading-6 text-gray-900\">Countries</a>
            <a href=\"{{ path('app_league_index') }}\" class=\"text-sm font-semibold leading-6 text-gray-900\">Leagues</a>
            <a href=\"{{ path('app_sport_index') }}\" class=\"text-sm font-semibold leading-6 text-gray-900\">Sports</a>
        </div>
        <div class=\"hidden lg:flex lg:flex-1 lg:justify-end\">
            <a href=\"{{ path('app_logout') }}\" class=\"text-sm font-semibold leading-6 text-gray-900\">Logout</a>
        </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class=\"lg:hidden\" role=\"dialog\" aria-modal=\"true\">
        <!-- Background backdrop, show/hide based on slide-over state. -->
        <div class=\"fixed inset-0 z-10\"></div>
        <div class=\"fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10\">
            <div class=\"flex items-center justify-between\">
                <a href=\"#\" class=\"-m-1.5 p-1.5\">
                    <span class=\"sr-only\">Your Company</span>
                    <img class=\"h-8 w-auto\" src=\"https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600\" alt=\"\">
                </a>
                <button type=\"button\" class=\"-m-2.5 rounded-md p-2.5 text-gray-700\">
                    <span class=\"sr-only\">Close menu</span>
                    <svg class=\"h-6 w-6\" fill=\"none\" viewBox=\"0 0 24 24\" stroke-width=\"1.5\" stroke=\"currentColor\" aria-hidden=\"true\">
                        <path stroke-linecap=\"round\" stroke-linejoin=\"round\" d=\"M6 18L18 6M6 6l12 12\" />
                    </svg>
                </button>
            </div>
            <div class=\"mt-6 flow-root\">
                <div class=\"-my-6 divide-y divide-gray-500/10\">
                    <div class=\"space-y-2 py-6\">
                        <div class=\"-mx-3\">
                            <button type=\"button\" class=\"flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50\" aria-controls=\"disclosure-1\" aria-expanded=\"false\">
                                Product
                                <!--
                                  Expand/collapse icon, toggle classes based on menu open state.

                                  Open: \"rotate-180\", Closed: \"\"
                                -->
                                <svg class=\"h-5 w-5 flex-none\" viewBox=\"0 0 20 20\" fill=\"currentColor\" aria-hidden=\"true\">
                                    <path fill-rule=\"evenodd\" d=\"M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z\" clip-rule=\"evenodd\" />
                                </svg>
                            </button>
                            <!-- 'Product' sub-menu, show/hide based on menu state. -->
                            <div class=\"mt-2 space-y-2\" id=\"disclosure-1\">
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Analytics</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Engagement</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Security</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Integrations</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Automations</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Watch demo</a>
                                <a href=\"#\" class=\"block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Contact sales</a>
                            </div>
                        </div>
                        <a href=\"{{ path('app_team_index') }}\" class=\"-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Teams</a>
                        <a href=\"#\" class=\"-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Marketplace</a>
                        <a href=\"#\" class=\"-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Company</a>
                    </div>
                    <div class=\"py-6\">
                        <a href=\"{{ path('app_logout') }}\" class=\"-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50\">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
", "ux/_header.html.twig", "/var/www/templates/ux/_header.html.twig");
    }
}
