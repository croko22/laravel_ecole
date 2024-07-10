<!-- ========== HEADER ========== -->
<header class="z-50 flex flex-wrap w-full md:justify-start md:flex-nowrap py-7">
    <nav class="relative flex flex-wrap items-center w-full px-4 mx-auto max-w-7xl md:grid md:grid-cols-12 basis-full md:px-6 md:px-8"
        aria-label="Global">
        <div class="md:col-span-3">
            <!-- Logo -->
            <a class="flex items-center text-xl font-semibold rounded-xl focus:outline-none focus:opacity-80"
                href={{ route('home') }}>
                <svg class="w-10 h-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    strokeWidth={1.5} stroke="currentColor" className="size-6">
                    <path strokeLinecap="round" strokeLinejoin="round"
                        d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                </svg>

                <span>
                    Laraecole
                </span>
                {{-- ROLE --}}
                <!-- Assuming $user is the authenticated user. If not, replace with Auth::user() where needed -->
                @if (auth()->check())
                    {{-- ROLE --}}
                    @if (auth()->user()->getRoleNames()->isNotEmpty())
                        <ul>
                            @foreach (auth()->user()->getRoleNames() as $role)
                                <li class="text-blue-500">-{{ $role }}</li>
                            @endforeach
                        </ul>
                    @endif
                @endif

            </a>
            <!-- End Logo -->
        </div>

        <!-- Button Group -->
        <div class="flex items-center py-1 gap-x-2 ms-auto md:ps-6 md:order-3 md:col-span-3">

            @hasrole('teacher')
                <a href={{ route('logout') }}
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-black transition border border-transparent gap-x-2 rounded-xl bg-lime-400 hover:bg-lime-500 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-lime-500">
                    Logout
                </a>
            @endhasrole


            @guest
                <a href={{ route('login') }}
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-black transition border border-transparent gap-x-2 rounded-xl bg-lime-400 hover:bg-lime-500 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-lime-500">
                    Log in
                </a>
            @endguest



            <div class="md:hidden">
                <button type="button"
                    class="hs-collapse-toggle size-[38px] flex justify-center items-center text-sm font-semibold rounded-xl border border-gray-200 text-black hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:border-neutral-700 dark:hover:bg-neutral-700"
                    data-hs-collapse="#navbar-collapse-with-animation" aria-controls="navbar-collapse-with-animation"
                    aria-label="Toggle navigation">
                    <svg class="flex-shrink-0 hs-collapse-open:hidden size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                    <svg class="flex-shrink-0 hidden hs-collapse-open:block size-4" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <!-- End Button Group -->

        <!-- Collapse -->
        <div id="navbar-collapse-with-animation"
            class="hidden overflow-hidden transition-all duration-300 hs-collapse basis-full grow md:block md:w-auto md:basis-auto md:order-2 md:col-span-6">
            @auth
                <div
                    class="flex flex-col mt-5 gap-y-4 gap-x-0 md:flex-row md:justify-center md:items-center md:gap-y-0 md:gap-x-7 md:mt-0">
                    <div>
                        <a class="relative inline-block text-black dark:text-white {{ request()->routeIs('course') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-lime-400' : '' }}"
                            href={{ route('course') }} aria-current="page">Courses</a>
                    </div>
                    <div>
                        <a class="relative inline-block text-black dark:text-white {{ request()->routeIs('student') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-lime-400' : '' }}"
                            href={{ route('student') }}>Students</a>
                    </div>
                    <div>
                        <a class="relative inline-block text-black dark:text-white {{ request()->routeIs('teacher') ? 'before:absolute before:bottom-0.5 before:start-0 before:-z-[1] before:w-full before:h-1 before:bg-lime-400' : '' }}"
                            href={{ route('teacher') }}>Teachers</a>
                    </div>
                </div>
            @endauth
        </div>
    </nav>
</header>
