## Stat cards

Use stat cards to easily display large numbers, great for any kind of simple metrics and dashboard content.

{% example html %}
<div class="statcard p-3">
  <h3 class="statcard-number">12,938</h3>
  <span class="statcard-desc">Page views</span>
</div>
<div class="statcard p-3 text-xs-center">
  <h3 class="statcard-number">758</h3>
  <span class="statcard-desc">Downloads</span>
</div>
<div class="statcard p-3 text-xs-right">
  <h3 class="statcard-number">1,293</h3>
  <span class="statcard-desc">Sign-ups</span>
</div>
{% endexample %}

With optional carets:

{% example html %}
<div class="statcard p-3">
  <h3 class="statcard-number">
    12,938
    <small class="delta-indicator delta-positive">5%</small>
  </h3>
  <span class="statcard-desc">Page views</span>
</div>
<div class="statcard p-3">
  <h3 class="statcard-number">
    758
    <small class="delta-indicator delta-negative">1.3%</small>
  </h3>
  <span class="statcard-desc">Downloads</span>
</div>
{% endexample %}

With background variations:

{% example html %}
<div class="statcard statcard-primary p-4 mb-2">
  <h3 class="statcard-number">
    12,938
    <small class="delta-indicator delta-positive">5%</small>
  </h3>
  <span class="statcard-desc">Page views</span>
</div>
<div class="statcard statcard-success p-4 mb-2">
  <h3 class="statcard-number">
    758
    <small class="delta-indicator delta-negative">1.3%</small>
  </h3>
  <span class="statcard-desc">Downloads</span>
</div>
<div class="statcard statcard-info p-4 mb-2">
  <h3 class="statcard-number">
    758
    <small class="delta-indicator delta-negative">1.3%</small>
  </h3>
  <span class="statcard-desc">Downloads</span>
</div>
<div class="statcard statcard-danger p-4 mb-2">
  <h3 class="statcard-number">
    1,293
    <small class="delta-indicator delta-positive">6.75%</small>
  </h3>
  <span class="statcard-desc">Sign-ups</span>
</div>
<div class="statcard statcard-warning p-4 mb-2">
  <h3 class="statcard-number">
    1,293
    <small class="delta-indicator delta-positive">6.75%</small>
  </h3>
  <span class="statcard-desc">Sign-ups</span>
</div>
{% endexample %}

And use the grid system to size and align them:

{% example html %}
<div class="row">
  <div class="col-sm-6">
    <div class="statcard statcard-primary p-4">
      <h3 class="statcard-number">
        12,938
        <small class="delta-indicator delta-positive">5%</small>
      </h3>
      <span class="statcard-desc">Page views</span>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="statcard statcard-success p-4">
      <h3 class="statcard-number">
        758
        <small class="delta-indicator delta-negative">1.3%</small>
      </h3>
      <span class="statcard-desc">Downloads</span>
    </div>
  </div>
</div>
{% endexample %}
