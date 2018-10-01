## Profile header

Simple profile headers to show off a user's profile information


{% example html %}
<div class="profile-header text-center" style="background-image: url({{ relative }}assets/img/iceland.jpg); ">
  <div class="container-fluid">
    <div class="container-inner">
      <img class="rounded-circle media-object" src="{{ relative }}assets/img/avatar-dhg.png">
      <h3 class="profile-header-user">Dave Gamache</h3>
      <p class="profile-header-bio">I wish i was a little bit taller, wish i was a baller, wish i had a girl… also.</p>
    </div>
  </div>
  <nav class="profile-header-nav">
    <ul class="nav nav-tabs justify-content-center">
      <li class="nav-item">
        <a class="nav-link active" href="#">Photos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Others</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Anothers</a>
      </li>
    </ul>
  </nav>
</div>
{% endexample %}
