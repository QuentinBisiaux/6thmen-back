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

/* team/index.html.twig */
class __TwigTemplate_5c837e442de7007282946a427e9f6827 extends Template
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
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "team/index.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "team/index.html.twig"));

        $this->parent = $this->loadTemplate("base.html.twig", "team/index.html.twig", 1);
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

        echo "Team index";
        
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
        <h1 class=\"font-extrabold text-2xl\">Teams</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"";
        // line 8
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_team_new");
        echo "\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold py-3\">Id</th>
                <th class=\"font-weight-bold\">Name</th>
                <th class=\"font-weight-bold\">Tricode</th>
                <th class=\"font-weight-bold\">Slug</th>
                <th class=\"font-weight-bold\">Sister</th>
                <th class=\"font-weight-bold\">CreatedIn</th>
                <th class=\"font-weight-bold\">EndedIn</th>
                <th class=\"font-weight-bold\">League</th>
                <th class=\"font-weight-bold\">CreatedAt</th>
                <th class=\"font-weight-bold\">UpdatedAt</th>
            </tr>
        </thead>
        <tbody>
        ";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["teams"]) || array_key_exists("teams", $context) ? $context["teams"] : (function () { throw new RuntimeError('Variable "teams" does not exist.', 27, $this->source); })()));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["team"]) {
            // line 28
            echo "            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">";
            // line 29
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 29), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 30
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "name", [], "any", false, false, false, 30), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 31
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "tricode", [], "any", false, false, false, 31), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 32
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "slug", [], "any", false, false, false, 32), "html", null, true);
            echo "</td>
                <td class=\"py-3\">";
            // line 33
            ((twig_get_attribute($this->env, $this->source, $context["team"], "sisterTeam", [], "any", false, false, false, 33)) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["team"], "sisterTeam", [], "any", false, false, false, 33), "name", [], "any", false, false, false, 33), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">";
            // line 34
            ((twig_get_attribute($this->env, $this->source, $context["team"], "createdIn", [], "any", false, false, false, 34)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "createdIn", [], "any", false, false, false, 34), "Y"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">";
            // line 35
            ((twig_get_attribute($this->env, $this->source, $context["team"], "endedIn", [], "any", false, false, false, 35)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "endedIn", [], "any", false, false, false, 35), "Y"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">
                    ";
            // line 37
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["team"], "league", [], "any", false, false, false, 37), "name", [], "any", false, false, false, 37), "html", null, true);
            echo "
                </td>
                <td class=\"py-3\">";
            // line 39
            ((twig_get_attribute($this->env, $this->source, $context["team"], "createdAt", [], "any", false, false, false, 39)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "createdAt", [], "any", false, false, false, 39), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">";
            // line 40
            ((twig_get_attribute($this->env, $this->source, $context["team"], "updatedAt", [], "any", false, false, false, 40)) ? (print (twig_escape_filter($this->env, twig_date_format_filter($this->env, twig_get_attribute($this->env, $this->source, $context["team"], "updatedAt", [], "any", false, false, false, 40), "Y-m-d H:i"), "html", null, true))) : (print ("")));
            echo "</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"";
            // line 42
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("app_team_edit", ["id" => twig_get_attribute($this->env, $this->source, $context["team"], "id", [], "any", false, false, false, 42)]), "html", null, true);
            echo "\">Edit</a>
                </td>
            </tr>
        ";
            $context['_iterated'] = true;
        }
        if (!$context['_iterated']) {
            // line 46
            echo "            <tr>
                <td colspan=\"10\">no records found</td>
            </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['team'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 50
        echo "        </tbody>
    </table>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    public function getTemplateName()
    {
        return "team/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  183 => 50,  174 => 46,  165 => 42,  160 => 40,  156 => 39,  151 => 37,  146 => 35,  142 => 34,  138 => 33,  134 => 32,  130 => 31,  126 => 30,  122 => 29,  119 => 28,  114 => 27,  92 => 8,  88 => 6,  78 => 5,  59 => 3,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends 'base.html.twig' %}

{% block title %}Team index{% endblock %}

{% block body %}
    <div class=\"flex\">
        <h1 class=\"font-extrabold text-2xl\">Teams</h1>
        <a class=\"ml-auto p-2 bg-indigo-600 text-white rounded-lg border-2\" href=\"{{ path('app_team_new') }}\">Add new</a>
    </div>

    <table class=\"min-w-full text-left\">
        <thead class=\"border-b-2 border-zinc-600\">
            <tr class=\"py-3\">
                <th class=\"font-weight-bold py-3\">Id</th>
                <th class=\"font-weight-bold\">Name</th>
                <th class=\"font-weight-bold\">Tricode</th>
                <th class=\"font-weight-bold\">Slug</th>
                <th class=\"font-weight-bold\">Sister</th>
                <th class=\"font-weight-bold\">CreatedIn</th>
                <th class=\"font-weight-bold\">EndedIn</th>
                <th class=\"font-weight-bold\">League</th>
                <th class=\"font-weight-bold\">CreatedAt</th>
                <th class=\"font-weight-bold\">UpdatedAt</th>
            </tr>
        </thead>
        <tbody>
        {% for team in teams %}
            <tr class=\"border-b-2 border-zinc-200\">
                <td class=\"py-3\">{{ team.id }}</td>
                <td class=\"py-3\">{{ team.name }}</td>
                <td class=\"py-3\">{{ team.tricode }}</td>
                <td class=\"py-3\">{{ team.slug }}</td>
                <td class=\"py-3\">{{ team.sisterTeam ? team.sisterTeam.name : '' }}</td>
                <td class=\"py-3\">{{ team.createdIn ? team.createdIn|date('Y') : '' }}</td>
                <td class=\"py-3\">{{ team.endedIn ? team.endedIn|date('Y') : '' }}</td>
                <td class=\"py-3\">
                    {{ team.league.name }}
                </td>
                <td class=\"py-3\">{{ team.createdAt ? team.createdAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">{{ team.updatedAt ? team.updatedAt|date('Y-m-d H:i') : '' }}</td>
                <td class=\"py-3\">
                    <a class=\"font-bold text-indigo-600\" href=\"{{ path('app_team_edit', {'id': team.id}) }}\">Edit</a>
                </td>
            </tr>
        {% else %}
            <tr>
                <td colspan=\"10\">no records found</td>
            </tr>
        {% endfor %}
        </tbody>
    </table>
{% endblock %}
", "team/index.html.twig", "/var/www/templates/team/index.html.twig");
    }
}
