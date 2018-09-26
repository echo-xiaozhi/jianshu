<div class="blog-masthead">
    <div class="container">
        <ul class="nav navbar-nav navbar-left">
            <li>
                <a class="blog-nav-item " href="/posts">首页</a>
            </li>
            <li>
                <a class="blog-nav-item" href="/posts/create">写文章</a>
            </li>
            <li>
                <a class="blog-nav-item" href="/notices">通知</a>
            </li>
            <form action="/posts/search" method="POST" style="float: left;">
                {{ csrf_field() }}
                <li style="float: left;">
                    <input name="query" type="text" value="" class="form-control" style="margin-top:10px" placeholder="搜索词">
                </li>
                <li style="float: left;">
                    <button class="btn btn-default" style="margin-top:10px" type="submit">Go!</button>
                </li>
            </form>


        </ul>

        <ul class="nav navbar-nav navbar-right">
            @if (!empty(\Auth::user()))
                <li class="dropdown">
                    <div>
                        <img src="/storage/9f0b0809fd136c389c20f949baae3957/iBkvipBCiX6cHitZSdTaXydpen5PBiul7yYCc88O.jpeg"
                             alt="" class="img-rounded" style="border-radius:500px; height: 30px">
                        <a href="#" class="blog-nav-item dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">{{ \Auth::user()->name }}<span
                                    class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/user/{{ \Auth::id() }}">我的主页</a></li>
                            <li><a href="/user/me/setting">个人设置</a></li>
                            <li><a href="/logout">登出</a></li>
                        </ul>
                    </div>
                </li>
                @else
                <li>
                    <a href="/login">登录</a>
                </li>
                <li>
                    <a href="/register">注册</a>
                </li>
            @endif
        </ul>
    </div>
</div>