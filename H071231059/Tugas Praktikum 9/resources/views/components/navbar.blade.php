<nav class="bg-slate-900 border-gray-200 ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-center mx-auto p-4">
      <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
        <ul class="flex  flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-slate-900 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-slate-900">
          <li>
            <a href="{{ route('category.index') }}" 
                class="block py-2 px-3 md:p-0 {{ request()->is('category') ? 'text-white bg-slate-400 rounded md:bg-transparent md:text-slate-400' : 'text-slate-100 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-slate-400'}}" 
                aria-current="page">
                Categories
            </a>
          </li>
          <li>
            <a href="{{ route('product.index') }}" 
                class="block py-2 px-3 md:p-0 {{ request()->is('product') ? 'text-white bg-slate-400 rounded md:bg-transparent md:text-slate-400' : 'text-slate-100 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-slate-400'}}">
                Products
            </a>
          </li>
          <li>
            <a href="{{ route('inventorylog.index') }}" 
                class="block py-2 px-3 md:p-0 {{ request()->is('inventorylog') ? 'text-white bg-slate-400 rounded md:bg-transparent md:text-slate-400' : 'text-slate-100 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-slate-400'}}">
                Inventory log
            </a>
          </li>
        </ul>
      </div>
    </div>
</nav>