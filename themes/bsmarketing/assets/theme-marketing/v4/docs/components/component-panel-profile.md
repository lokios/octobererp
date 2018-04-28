## Card profile

Feature a user's profile with the `.card-profile` variant.

{% example html %}
<div class="mt-2">
  <div class="row">
    <div class="col-lg-6">
      <div class="card card-profile">
        <div class="card-header" style="background-image: url(https://igcdn-photos-h-a.akamaihd.net/hphotos-ak-xfa1/t51.2885-15/11312291_348657648678007_1202941362_n.jpg);"></div>
        <div class="card-block text-xs-center">
          <img class="card-profile-img" src="{{ relative }}assets/img/avatar-fat.jpg">
          <h5 class="card-title">Jacob Thornton</h5>
          <p class="mb-4">Big belly rude boy, million dollar hustler. Unemployed.</p>
          <button class="btn btn-outline-primary btn-sm">
            <span class="icon icon-add-user"></span> Follow
          </button>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card card-profile">
        <div class="card-header" style="background-image: url(https://igcdn-photos-h-a.akamaihd.net/hphotos-ak-xaf1/t51.2885-15/11240760_365538423656311_112029877_n.jpg);"></div>
        <div class="card-block text-xs-center">
          <img class="card-profile-img" src="{{ relative }}assets/img/avatar-mdo.png">
          <h5 class="card-title">Mark Otto</h5>
          <p class="mb-4">GitHub and Bootstrap. Formerly at Twitter. Huge nerd.</p>
          <button class="btn btn-outline-primary btn-sm">
            <span class="icon icon-add-user"></span> Follow
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
{% endexample %}
