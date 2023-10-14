<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                <a class="nav-link" href="{{ route('home') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                @can('CRUD Role')
                    <a class="nav-link" href="{{ url('roles') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-ban"></i></div>
                        Roles
                    </a>
                @endcan
                @can('Crud Permission')
                    <a class="nav-link" href="{{ url('permissions') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-ban"></i></div>
                        Permissions
                    </a>
                @endcan
                <a class="nav-link collapsed @if ($active == 'subject') active @endif" data-toggle="collapse"
                    data-target="#collapseSubjects" aria-expanded="false" href="#collapseSubjects"
                    aria-controls="collapseSubjects">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Subject
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseSubjects" aria-labelledby="headingOne"
                    data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('teacher.create.subject') }}">Add Subject</a>
                        <a class="nav-link" href="{{ route('subject.list') }}">Subject</a>
                    </nav>
                </div>

                <a class="nav-link collapsed @if ($active == 'quiz') active @endif" data-toggle="collapse"
                    data-target="#collapseQuizs" aria-expanded="false" aria-controls="collapseQuizs"
                    href="#collapseQuizs">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Quiz
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseQuizs" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('create.quiz') }}">Add Quiz</a>
                        <a class="nav-link" href="{{ route('quiz.view') }}">Quiz</a>
                        <a class="nav-link" href="{{ route('create.question') }}">Add Questions</a>
                    </nav>
                </div>
                @if (auth()->user()->usertype_id == 1)
                    <a class="nav-link collapsed @if ($active == 'user') active @endif" data-toggle="collapse"
                        data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers"
                        href="#collapseUsers">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        User
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseUsers" aria-labelledby="headingOne"
                        data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            {{-- <a class="nav-link" href="{{ route('create.User') }}">Add User</a> --}}
                            <a class="nav-link" href="{{ route('user.list') }}">User</a>
                            {{-- <a class="nav-link" href="{{ route('create.question') }}">Add Questions</a> --}}
                        </nav>
                    </div>
                @endif
    </nav>
</div>
