
	<!-- BEGIN SIDEBAR -->
	<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->
			<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
			<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
			<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
			<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<li {{ (Request::is('home') ? 'class=active' : '') }}>
					<a href="/home">
					<i class="icon-home"></i>
					<span class="title">Inicio</span>
					</a>
				</li>
				<li {{ (Request::is('empleado/mostrar') ? 'class=active' : '') }}>
					<a href="/empleado/mostrar">
					<i class="icon-users"></i>
					<span class="title">Administrar Empleados</span>
					</a>
				</li>

				@if((\Illuminate\Support\Facades\Auth::user()->id_role == 2) || (\Illuminate\Support\Facades\Auth::user()->id_role == 1))
				<li class="clients_list" >
					<a href="javascript:;">
					<i class="icon-users"></i>
					<span class="title">Administrar Clientes</span>
					<span class="arrow {{ (Request::is('cliente/*') ? 'open' : '')}}"></span>
					</a>
					<ul class="sub-menu" id="clients_menu">
						<li {{ (Request::is('cliente/mostrar') ? 'class=active' : '') }}>
							<a href="/cliente/mostrar">
							<i class="icon-user"></i>
							Clientes</a>
						</li>
						<li {{ (Request::is('cliente/usersReferred') ? 'class=active' : '') }}>
							<a href="/cliente/usersReferred">
							<i class="icon-user-follow"></i>
							Usuarios Referidos</a>
						</li>
					</ul>
				</li>
				@endif

				@if((\Illuminate\Support\Facades\Auth::user()->id_role == 2) || (\Illuminate\Support\Facades\Auth::user()->id_role == 1))
				<li {{ (Request::is('costos/mostrar') ? 'class=active' : '') }}>
					<a href="/costos/mostrar">
					<i class="glyphicon glyphicon-th"></i>
					<span class="title">Centro de Costos</span>
					</a>
				</li>
				@endif

				@if((\Illuminate\Support\Facades\Auth::user()->id_role == 2) || (\Illuminate\Support\Facades\Auth::user()->id_role == 1))
				<li {{ (Request::is('aclaraciones/aclaraciones') ? 'class=active' : '') }}>
					<a href="/aclaraciones/aclaraciones">
					<i class="glyphicon glyphicon-pushpin"></i>
					<span class="title">Aclaraciones</span>
					</a>
				</li>
				@endif

				@if((\Illuminate\Support\Facades\Auth::user()->id_role == 2) || (\Illuminate\Support\Facades\Auth::user()->id_role == 1))
				<li {{ (Request::is('auditorias/auditorias') ? 'class=active' : '') }}>
					<a href="/auditorias/auditorias">
					<i class="glyphicon glyphicon-briefcase"></i>
					<span class="title">Auditorias</span>
					</a>
				</li>
				@endif

				<li class="options_list">
					<a href="/documentos/control">
					<i class="icon-notebook"></i>
					<span class="title">Control Documentos</span>
					<span class="arrow {{ (Request::is('documentos/*') ? 'open' : '')}}"></span>
					</a>
					<ul class="sub-menu" id="menu" >
						<li class="{{ (Request::is('documentos/control') ? 'active' : '') }}">
							<a class="menu_list" href="/documentos/control">
							<i class="glyphicon glyphicon-barcode"></i>
							Entradas y Salidas</a>
						</li>
						<li class="{{ (Request::is('documentos/historico') ? 'active' : '') }}">
							<a href="/documentos/historico">
							<i class="icon-notebook"></i>
							Historico de Documentos</a>
						</li>
						<li class="{{ (Request::is('tipos/tipos') ? 'active' : '') }}">
							<a href="/tipos/tipos">
							<i class="glyphicon glyphicon-list-alt"></i>
							Tipos de Documentos</a>
						</li>
						<li class="{{ (Request::is('subtipos/subtipos') ? 'active' : '') }}">
							<a href="/subtipos/subtipos">
							<i class="glyphicon glyphicon-list-alt"></i>
							Subtipos de Documentos</a>
						</li>
					</ul>
				</li>
				@if((\Illuminate\Support\Facades\Auth::user()->id_role == 2) || (\Illuminate\Support\Facades\Auth::user()->id_role == 1))
				<li {{ (Request::is('charges/showChargesAndDeposits') ? 'class=active' : '') }}>
					<a href="/charges/showChargesAndDeposits">
					<i class="icon-grid"></i>
					<span class="title">Cargos y Abonos</span>
					</a>
				</li>
				@endif
				
				<li class="graphics_list">
					<a href="javascript:;">
					<i class="icon-graph"></i>
					<span class="title">Reportes y Graficas</span>
					<span class="arrow {{ (Request::is('reportsAndGraphics/*') ? 'open' : '')}}"></span>
					</a>
					<ul class="sub-menu" id="graphics_menu">
						<li {{ (Request::is('reportsAndGraphics/chargedVsExpected') ? 'class=active' : '') }}>
							<a href="/reportsAndGraphics/chargedVsExpected">
							<i class="icon-folder-alt"></i>
							Reportes de Cobro</a>
						</li >
						<li {{ (Request::is('reportsAndGraphics/clientsReport') ? 'class=active' : '') }}>
							<a href="/reportsAndGraphics/clientsReport">
							<i class="icon-drawer"></i>
							Reportes Cliente</a>
						</li>
						<li {{ (Request::is('reportsAndGraphics/statisticServices') ? 'class=active' : '') }}>
							<a href="/reportsAndGraphics/statisticServices">
							<i class="icon-folder-alt"></i>
							Estadisticas Servicios</a>
						</li>
						<li {{ (Request::is('reportsAndGraphics/financesReport') ? 'class=active' : '') }}>
							<a href="/reportsAndGraphics/financesReport">
							<i class="icon-folder-alt"></i>
							Reporte de Finanzas</a>
						</li>
					</ul>
				</li>
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
