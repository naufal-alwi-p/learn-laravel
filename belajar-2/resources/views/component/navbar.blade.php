<nav class="navbar sticky-top navbar-expand-lg bg-success-subtle py-3 shadow-sm mb-3">
    <div class="container-fluid ps-5">
      <a class="navbar-brand" href="/">Website Blog</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a @class(['nav-link', 'active' => isset($home_nav)]) aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a @class(['nav-link', 'active' => isset($categories_nav)]) href="/categories">Categories</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              More
            </a>
            <ul class="dropdown-menu">
              <li><a @class(['dropdown-item', 'fw-bold' => isset($new_post_nav)]) href="/new-post">Create New Post</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a @class(['dropdown-item']) href="/belajar-laravel">Belajar Laravel</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>