import Swal from "sweetalert2";
import {toast} from "vue3-toastify";
import 'vue3-toastify/dist/index.css';

export function eliminarDados(rota, inertiaInstance) {
    Swal.fire({
        title: "Tem a certeza?",
        text: "Nao podera reverter apos eliminacao!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, pode eliminar!",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            inertiaInstance.delete(rota, {
                onSuccess: () => {
                    toast("Dados Eliminados Com Sucesso!", {
                        autoClose: 2000,
                        pauseOnHover: true,
                        onClose: props => {
                            window.location.reload()
                        },
                    });

                },
                onError: () => {
                    toast('Erro Ao Eliminar!!', {
                        autoClose: 2000,
                        pauseOnHover: true,
                        onClose: props => {
                            window.location.reload()
                        },
                    })
                }
            });
        }
    });
}
