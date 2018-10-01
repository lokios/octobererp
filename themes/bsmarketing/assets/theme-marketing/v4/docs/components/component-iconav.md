## Icon nav

The icon nav is a special sidebar navigation for this toolkit. In mobile viewports, the icon nav is horizontal with icons and textual labels. On larger devices the icon nav changes and becomes affixed to the side of the viewport with tooltips instead of textual labels.

{% example html %}
<nav class="iconav">
    <a class="iconav-brand" href="#">
      <span class="icon icon-leaf iconav-brand-icon"></span>
    </a>
    <div class="iconav-slider">
      <ul class="nav nav-pills iconav-nav flex-md-column">
        <li class="nav-item">
          <a class="nav-link" href="#" title="Overview" data-toggle="tooltip" data-placement="right" data-container="body">
            <span class="icon icon-home"></span>
            <small class="iconav-nav-label d-md-none">Overview</small>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Order history" data-toggle="tooltip" data-placement="right" data-container="body">
            <span class="icon icon-text-document"></span>
            <small class="iconav-nav-label d-md-none">History</small>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Fluid layout" data-toggle="tooltip" data-placement="right" data-container="body">
            <span class="icon icon-globe"></span>
            <small class="iconav-nav-label d-md-none">Fluid layout</small>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Icon-nav layout" data-toggle="tooltip" data-placement="right" data-container="body">
            <span class="icon icon-area-graph"></span>
            <small class="iconav-nav-label d-md-none">Icon nav</small>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="#" title="Docs" data-toggle="tooltip" data-placement="right" data-container="body">
            <span class="icon icon-list"></span>
            <small class="iconav-nav-label d-md-none">Docs</small>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Light UI" data-toggle="tooltip" data-placement="right" data-container="body">
            <span class="icon icon-flash"></span>
            <small class="iconav-nav-label d-md-none">Light UI</small>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" title="Signed in as mdo" data-toggle="tooltip" data-placement="right" data-container="body">
            <img src="{{ relative }}assets/img/avatar-mdo.png" alt="" class="rounded-circle img-fluid">
            <small class="iconav-nav-label d-md-none">@mdo</small>
          </a>
        </li>
      </ul>
    </div>
  </nav>
{% endexample %}
