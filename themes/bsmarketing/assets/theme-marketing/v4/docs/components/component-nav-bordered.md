## Nav bordered

The bordered nav builds on Bootstrap's `.nav` base styles with a new, bolder variation to nav links.

{% example html %}
<ul class="nav nav-bordered">
  <li class="nav-item">
    <a class="nav-link active" href="#">Bold</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Minimal</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Components</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Docs</a>
  </li>
</ul>
{% endexample %}

Bordered nav links can also be stacked:

{% example html %}
<ul class="nav nav-bordered nav-stacked flex-column">
  <li class="nav-header">Examples</li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Bold</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Minimal</a>
  </li>
  
  <li class="nav-header">Sections</li>

  <li class="nav-item">
    <a class="nav-link" href="#">Grid</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Pricing</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">About</a>
  </li>
</ul>
{% endexample %}
