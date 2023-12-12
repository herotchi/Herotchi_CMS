<nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-bottom-dark mb-3" data-bs-theme="dark">
  	<div class="container-fluid">
    	<a class="navbar-brand" href="{{ route('admin.top') }}"><strong>Herotchi_CMS<span class="text-danger ps-2">管理画面</span></strong></a>
    	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      		<span class="navbar-toggler-icon"></span>
    	</button>
    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
      		<ul class="navbar-nav me-auto mb-2 mb-lg-0">
        		<li class="nav-item">
          			<a class="nav-link @if($page=='admin.top') active @endif" @if($page=='admin.top')aria-current="page"@endif href="{{ route('admin.top') }}">TOP</a>
        		</li>
				<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if($page=='admin.news.add' || $page=='admin.news.list' || $page=='admin.news.detail' || $page=='admin.news.edit') active @endif" 
                    @if($page=='admin.news.add' || $page=='admin.news.list' || $page=='admin.news.detail' || $page=='admin.news.edit')aria-current="page"@endif href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">お知らせ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item @if($page=='admin.news.add') active @endif" href="{{ route('admin.news.add') }}">お知らせ登録</a></li>
                        <li><a class="dropdown-item @if($page=='admin.news.list') active @endif" href="{{ route('admin.news.list') }}">お知らせ一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle
                        @if($page=='admin.first_category.add' || $page=='admin.first_category.list' || $page=='admin.first_category.detail' || $page=='admin.first_category.edit'|| $page=='admin.first_category.csv_add' 
                        || $page=='admin.second_category.add' || $page=='admin.second_category.list' || $page=='admin.second_category.detail' || $page=='admin.second_category.edit' || $page=='admin.second_category.csv_add') active @endif" 
                        @if($page=='admin.first_category.add' || $page=='admin.first_category.list' || $page=='admin.first_category.detail' || $page=='admin.first_category.edit' 
                        || admin.second_category.add' || $page=='admin.second_category.list' || $page=='admin.second_category.detail' || $page=='admin.second_category.edit')aria-current="page"@endif
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">カテゴリ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item @if($page=='admin.first_category.add') active @endif" href="{{ route('admin.first_category.add') }}">大カテゴリ登録</a></li>
                        <li><a class="dropdown-item @if($page=='admin.first_category.list') active @endif" href="{{ route('admin.first_category.list') }}">大カテゴリ一覧</a></li>
                        <li><a class="dropdown-item @if($page=='admin.first_category.csv_add') active @endif" href="{{ route('admin.first_category.csv_add') }}">大カテゴリCSV登録</a></li>
                        <li><a class="dropdown-item @if($page=='admin.second_category.add') active @endif" href="{{ route('admin.second_category.add') }}">中カテゴリ登録</a></li>
                        <li><a class="dropdown-item @if($page=='admin.second_category.list') active @endif" href="{{ route('admin.second_category.list') }}">中カテゴリ一覧</a></li>
                        <li><a class="dropdown-item @if($page=='admin.second_category.csv_add') active @endif" href="{{ route('admin.second_category.csv_add') }}">中カテゴリCSV登録</a></li>
                        
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if($page=='admin.product.add' || $page=='admin.product.list' || $page=='admin.product.detail' || $page=='admin.product.edit') active @endif" 
                    @if($page=='admin.product.add' || $page=='admin.product.list' || $page=='admin.product.detail' || $page=='admin.product.edit')aria-current="page"@endif href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">製品情報</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item @if($page=='admin.product.add') active @endif" href="{{ route('admin.product.add') }}">製品情報登録</a></li>
                        <li><a class="dropdown-item @if($page=='admin.product.list') active @endif" href="{{ route('admin.product.list') }}">製品情報一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if($page=='admin.media.add' || $page=='admin.media.list' || $page=='admin.media.detail' || $page=='admin.media.edit') active @endif" 
                    @if($page=='admin.media.add' || $page=='admin.media.list' || $page=='admin.media.detail' || $page=='admin.media.edit')aria-current="page"@endif href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">メディア</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item @if($page=='admin.media.add') active @endif" href="{{ route('admin.media.add') }}">メディア登録</a></li>
                        <li><a class="dropdown-item @if($page=='admin.media.list') active @endif" href="{{ route('admin.media.list') }}">メディア一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if($page=='admin.contact.list' || $page=='admin.contact.detail') active @endif" 
                    @if($page=='admin.contact.list' || $page=='admin.contact.detail')aria-current="page"@endif href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">お問い合わせ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item @if($page=='admin.contact.list') active @endif" href="{{ route('admin.contact.list') }}">お問い合わせ一覧</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if($page=='admin.user.login') active @endif" 
                    @if($page=='admin.user.login')aria-current="page"@endif href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">ユーザー</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item @if($page=='admin.user.login') active @endif" href="{{ route('admin.user.login') }}">ログイン情報変更</a></li>
                    </ul>
                </li>
      		</ul>
            <form class="" action="{{ route('admin.auth.logout') }}" method="POST">
                @csrf
                <button class="btn btn-outline-success" type="submit">ログアウト</button>
            </form>
    	</div>
  	</div>
</nav>
