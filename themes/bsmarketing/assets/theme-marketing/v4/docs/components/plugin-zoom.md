## Zoom

The zoom plugin provides simple image zoom functionality. Add a `data-action="zoom"` attribute to any image you want to make zoomable. Zoomed images can be closed by scroll, `esc`, or click. Use the meta key to open raw element in new tab.

### Data API

{% example html %}
<img data-action="zoom" style="width: 150px;" src="{{ relative }}assets/img/avatar-mdo.png">
{% endexample %}
