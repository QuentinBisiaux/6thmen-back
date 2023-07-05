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

/* standing/index.html.twig */
class __TwigTemplate_cfcb690022f5ce1719fdc154bfa0e29c extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'title' => [$this, 'block_title'],
            'body' => [$this, 'block_body'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "standing/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "standing/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "standing/index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "title"));

        echo "Standing index";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 5
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "body"));

        // line 6
        echo "    <div class=\"flex\">
        <h1 class=\"font-extrabold text-2xl\">Standings</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"";
        // line 8
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_standing_new");
        echo "\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold py-3\">Id</th>
                <th class=\"font-weight-bold\">League</th>
                <th class=\"font-weight-bold\">Season</th>
                <th class=\"font-weight-bold\">Team</th>
                <th class=\"font-weight-bold\">Rank</th>
                <th class=\"font-weight-bold\">Victory</th>
                <th class=\"font-weight-bold\">Loses</th>
                <th class=\"font-weight-bold\">Created At</th>
                <th class=\"font-weight-bold\">Updated At</th>
            </tr>
        </thead>
        <tbody>
        ";
        // line 26
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["standings"]) || array_key_exists("standings", $context) ? $context["standings"] : (function () { throw new RuntimeError('Variable "standings" does not exist.', 26, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["standing"]) {
            // line 27
            echo "            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">";
            // line 28
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["standing"], "id", [], "any", false, false, false, 28), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 29
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["standing"], "league", [], "any", false, false, false, 29), "name", [], "any", false, false, false, 29), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 30
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["standing"], "season", [], "any", false, false, false, 30), "year", [], "any", false, false, false, 30), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 31
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["standing"], "team", [], "any", false, false, false, 31), "name", [], "any", false, false, false, 31), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 32
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["standing"], "rank", [], "any", false, false, false, 32), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 33
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["standing"], "victory", [], "any", false, false, false, 33), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 34
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["standing"], "loses", [], "any", false, false, false, 34), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 35
            ((twig_get_attribute($this->env, $this->source, $context["standing"], "createdAt", [], "any", false, false, false, 35)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["standing"], "createdAt", [], "any", false, false, false, 35), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">";
            // line 36
            ((twig_get_attribute($this->env, $this->source, $context["standing"], "updatedAt", [], "any", false, false, false, 36)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["standing"], "updatedAt", [], "any", false, false, false, 36), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"";
            // line 38
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_standing_edit", ["id" => twig_get_attribute($this->env, $this->source, $context["standing"], "id", [], "any", false, false, false, 38)]), "html", null, true);
            echo "\">Edit</a>
                </td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 42
            echo "            <tr>
                <td colspan=\"4\">no records found</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['standing'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        echo "        </tbody>
    </table>

";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "standing/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  176 => 46,  167 => 42,  158 => 38,  153 => 36,  149 => 35,  145 => 34,  141 => 33,  137 => 32,  133 => 31,  129 => 30,  125 => 29,  121 => 28,  118 => 27,  113 => 26,  92 => 8,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Standing index{% endblock %}

{% block body %}
    <div class=\"flex\">
        <h1 class=\"font-extrabold text-2xl\">Standings</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"{{ path('app_standing_new') }}\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold py-3\">Id</th>
                <th class=\"font-weight-bold\">League</th>
                <th class=\"font-weight-bold\">Season</th>
                <th class=\"font-weight-bold\">Team</th>
                <th class=\"font-weight-bold\">Rank</th>
                <th class=\"font-weight-bold\">Victory</th>
                <th class=\"font-weight-bold\">Loses</th>
                <th class=\"font-weight-bold\">Created At</th>
                <th class=\"font-weight-bold\">Updated At</th>
            </tr>
        </thead>
        <tbody>
        {% for standing in standings %}
            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">{{ standing.id }}</td>
                <td class=\"py-3\">{{ standing.league.name }}</td>
                <td class=\"py-3\">{{ standing.season.year }}</td>
                <td class=\"py-3\">{{ standing.team.name }}</td>
                <td class=\"py-3\">{{ standing.rank }}</td>
                <td class=\"py-3\">{{ standing.victory }}</td>
                <td class=\"py-3\">{{ standing.loses }}</td>
                <td class=\"py-3\">{{ standing.createdAt ? standing.createdAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">{{ standing.updatedAt ? standing.updatedAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"{{ path('app_standing_edit', {'id': standing.id}) }}\">Edit</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan=\"4\">no records found</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>

{% endblock %}
", "standing/index.html.twig", "/var/www/templates/standing/index.html.twig");
    }
}
