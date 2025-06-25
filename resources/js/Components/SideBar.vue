<script>
export default {
    name: "SideBar"
}
</script>

<template>
    <div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
        <div class="sidebar-header border-bottom">
            <div class="sidebar-brand">
                <svg class="sidebar-brand-full" width="88" height="32" alt="CoreUI Logo">
                    <use xlink:href="/assets/brand/coreui.svg#full"></use>
                </svg>
                <svg class="sidebar-brand-narrow" width="32" height="32" alt="CoreUI Logo">
                    <use xlink:href="/assets/brand/coreui.svg#signet"></use>
                </svg>
            </div>
            <button class="btn-close d-lg-none"
                    type="button"
                    data-coreui-theme="dark"
                    aria-label="Close"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()">
            </button>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
            <li class="nav-item"><a class="nav-link" href="/dashboard">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-speedometer"></use>
                </svg>
                Dashboard
            </a></li>

            <li class="nav-title">Dados Imóveis</li>
            <li class="nav-item"><a class="nav-link" href="/tipologias">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-house"></use>
                </svg>
                Tipologias</a></li>
            <li class="nav-item"><a class="nav-link" href="/property-types">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-room"></use>
                </svg>
                Tipo Imóveis</a></li>
            <li class="nav-item"><a class="nav-link" href="/property-types">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-save"></use>
                </svg>
                Imóveis</a></li>


            <li class="nav-title">Contractos</li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-notes"></use>
                </svg>
                Clientes</a></li>
            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-notes"></use>
                </svg>
                Contractos</a>
                <ul class="nav-group-items compact">
                    <li class="nav-item"><a class="nav-link" href="#"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> Arrendamento</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><span class="nav-icon"><span
                        class="nav-icon-bullet"></span></span> Compra</a></li>
                </ul>
            </li>

            <li class="nav-title">Facturação</li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-chart-pie"></use>
                </svg>
                Facturas</a></li>
            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-chart-pie"></use>
                </svg>
                SAF-T</a></li>

            <li class="nav-item"><a class="nav-link" href="#">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-chart-pie"></use>
                </svg>
                Pagamentos</a></li>

            <li class="nav-title">Administração</li>
            <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="/coreui/icons/sprites/free.svg#cil-cursor"></use>
                </svg>
                Acessos</a>
                <ul class="nav-group-items compact">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            Grupo Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            Grupos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            Permissoes
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link" href="#">

                    Ajuda?
                </a>
            </li>
        </ul>
        <div class="sidebar-footer border-top d-none d-md-flex">
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        </div>
    </div>
</template>

<style scoped>

</style>
