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

/* login/index.html.twig */
class __TwigTemplate_b56127a576a6e56393909bcc405fa4a6 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "login/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "login/index.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html class=\"h-full bg-white\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Login</title>
        <link rel=\"icon\" href=\"data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>\">
        <script src=\"https://cdn.tailwindcss.com\"></script>
    </head>
    <body class=\"h-full\">
        <div class=\"flex min-h-full flex-col justify-center px-6 py-12 lg:px-8\">
            <div class=\"sm:mx-auto sm:w-full sm:max-w-sm\">
                <img class=\"mx-auto h-10 w-auto\" src=\"https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600\" alt=\"Your Company\">
                <h2 class=\"mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900\">Connexion</h2>
            </div>
            ";
        // line 15
        if ((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 15, $this->source); })())) {
            // line 16
            echo "                <div>";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 16, $this->source); })()), "messageKey", [], "any", false, false, false, 16), twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new RuntimeError('Variable "error" does not exist.', 16, $this->source); })()), "messageData", [], "any", false, false, false, 16), "security"), "html", null, true);
            echo "</div>
            ";
        }
        // line 18
        echo "
            <div class=\"mt-10 sm:mx-auto sm:w-full sm:max-w-sm\">
                <form class=\"space-y-6\" action=\"";
        // line 20
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_login");
        echo "\" method=\"POST\">
                    <div>
                        <label for=\"username\" class=\"block text-sm font-medium leading-6 text-gray-900\">Username</label>
                        <div class=\"mt-2\">
                            <input id=\"username\" name=\"_username\" type=\"text\" value=\"";
        // line 24
        echo twig_escape_filter($this->env, (isset($context["last_username"]) || array_key_exists("last_username", $context) ? $context["last_username"] : (function () { throw new RuntimeError('Variable "last_username" does not exist.', 24, $this->source); })()), "html", null, true);
        echo "\" required class=\"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6\">
                        </div>
                    </div>

                    <div>
                        <div class=\"flex items-center justify-between\">
                            <label for=\"password\" class=\"block text-sm font-medium leading-6 text-gray-900\">Password</label>
                        </div>
                        <div class=\"mt-2\">
                            <input id=\"password\" name=\"_password\" type=\"password\" autocomplete=\"current-password\" required class=\"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6\">
                        </div>
                    </div>

                    ";
        // line 39
        echo "
                    <div>
                        <button type=\"submit\" class=\"flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600\">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>";
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    public function getTemplateName()
    {
        return "login/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 39,  78 => 24,  71 => 20,  67 => 18,  61 => 16,  59 => 15,  43 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("<!DOCTYPE html>
<html class=\"h-full bg-white\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Login</title>
        <link rel=\"icon\" href=\"data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>\">
        <script src=\"https://cdn.tailwindcss.com\"></script>
    </head>
    <body class=\"h-full\">
        <div class=\"flex min-h-full flex-col justify-center px-6 py-12 lg:px-8\">
            <div class=\"sm:mx-auto sm:w-full sm:max-w-sm\">
                <img class=\"mx-auto h-10 w-auto\" src=\"https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600\" alt=\"Your Company\">
                <h2 class=\"mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900\">Connexion</h2>
            </div>
            {% if error %}
                <div>{{ error.messageKey|trans(error.messageData, 'security') }}</div>
            {% endif %}

            <div class=\"mt-10 sm:mx-auto sm:w-full sm:max-w-sm\">
                <form class=\"space-y-6\" action=\"{{ path('app_login') }}\" method=\"POST\">
                    <div>
                        <label for=\"username\" class=\"block text-sm font-medium leading-6 text-gray-900\">Username</label>
                        <div class=\"mt-2\">
                            <input id=\"username\" name=\"_username\" type=\"text\" value=\"{{ last_username }}\" required class=\"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6\">
                        </div>
                    </div>

                    <div>
                        <div class=\"flex items-center justify-between\">
                            <label for=\"password\" class=\"block text-sm font-medium leading-6 text-gray-900\">Password</label>
                        </div>
                        <div class=\"mt-2\">
                            <input id=\"password\" name=\"_password\" type=\"password\" autocomplete=\"current-password\" required class=\"block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6\">
                        </div>
                    </div>

                    {# If you want to control the URL the user is redirected to on success
                    <input type=\"hidden\" name=\"_target_path\" value=\"/account\"> #}

                    <div>
                        <button type=\"submit\" class=\"flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600\">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>", "login/index.html.twig", "/var/www/templates/login/index.html.twig");
    }
}
