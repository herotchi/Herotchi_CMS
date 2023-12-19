<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark mb-3" data-bs-theme="dark">
  	<div class="container-fluid">
    	<a class="navbar-brand" href="{{ route('top') }}"><strong>Herotchi_CMS</strong></a>
    	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
    	</button>
    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
      		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
        		<li class="nav-item">
          			<a class="nav-link @if($page=='top') active @endif" @if($page=='top')aria-current="page"@endif href="{{ route('top') }}">TOP</a>
        		</li>
				<li class="nav-item">
                    <a class="nav-link @if($page=='news.list' || $page=='news.detail') active @endif" @if($page=='news.list' || $page=='news.detail')aria-current="page"@endif href="{{ route('news.list') }}">お知らせ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($page=='product.list' || $page=='product.detail') active @endif" @if($page=='product.list' || $page=='product.detail')aria-current="page"@endif href="{{ route('product.list') }}">製品情報</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($page=='contact.add' || $page=='contact.confirm' || $page=='contact.complete') active @endif" @if($page=='contact.add' || $page=='contact.confirm' || $page=='contact.complete')aria-current="page"@endif href="{{ route('contact.add') }}">お問い合わせ</a>
                </li>
      		</ul>
    	</div>
  	</div>
</nav>
