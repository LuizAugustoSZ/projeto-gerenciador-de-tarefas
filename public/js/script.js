$(document).ready(function () {
    // Carrega as tarefas na abertura da página
    carregarTarefas();

    // Filtro por status
    $("#filterStatus").on("change", carregarTarefas);

    // Barra de pesquisa
    $("#search").on("keyup", carregarTarefas);

    // Quando clicar em Nova Tarefa, limpa o formulário e ajusta o título
    $("#btnNew").on("click", function () {
        resetarFormularioTask();
        $(".modal-title").text("Nova tarefa");
    });

    // Quando o modal fechar, sempre reseta o formulário
    $("#modalTask").on("hidden.bs.modal", function () {
        resetarFormularioTask();
    });

    // Envio do formulário (criar ou editar)
    $("#formTask").on("submit", function (e) {
        e.preventDefault();

        // Se existir ID, é edição; senão, criação
        let id = $("#taskId").val();
        let action = id ? "controllers/task_edit.php" : "controllers/task_create.php";

        // Envia os dados
        $.post(action, $(this).serialize(), function (res) {
            if (res.success) {
                $("#modalTask").modal("hide");
                carregarTarefas();
            } else {
                alert(res.message);
            }
        });
    });

    // Confirmação do modal de exclusão
    $("#confirmDelete").click(function () {
        let id = $("#delete_id").val();

        $.post("controllers/task_delete.php", { id }, function (res) {
            if (res.success) {
                $("#modalDelete").modal("hide");
                carregarTarefas();
            }
        });
    });
});

// Limpa todos os campos do modal e garante estado inicial
function resetarFormularioTask() {
    $("#formTask")[0].reset();
    $("#taskId").val("");
    $(".modal-title").text("Nova tarefa");
}

// Carrega toda a lista de tarefas filtrada
function carregarTarefas() {
    let status = $("#filterStatus").val();
    let search = $("#search").val().trim();

    $.get("controllers/task_list.php", { status, search }, function (res) {

        if (!res.success) return;

        // Caso não tenha nenhuma tarefa
        if (res.tasks.length === 0) {
            $("#tasksList").html(`
                <p class="text-muted text-center mt-3">Nenhuma tarefa encontrada.</p>
            `);
            return;
        }

        // Lista gerada dinamicamente
        let html = "";
        res.tasks.forEach(t => {
            html += `
                <div class="card mb-2 p-3 ${t.status === "concluida" ? "task-done" : ""}">
                    <h5>${t.titulo}</h5>
                    <p>${t.descricao ?? ""}</p>
                    <small>Data limite: ${t.data_limite ?? "—"}</small><br>
                    <small>Status: <b>${t.status}</b></small>

                    <div class="mt-2">
                        <button class="btn btn-sm btn-success" onclick="toggleTask(${t.id})">Alternar</button>
                        <button class="btn btn-sm btn-warning" onclick="editar(${t.id})">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="abrirModalDelete(${t.id})">Deletar</button>
                    </div>
                </div>
            `;
        });

        $("#tasksList").html(html);
    });
}

// Alterna o status da tarefa
function toggleTask(id) {
    $.post("controllers/task_toggle.php", { id }, function (res) {
        if (res.success) carregarTarefas();
    });
}

// Busca os dados e preenche o modal para edição
function editar(id) {
    $.get("controllers/task_edit.php", { id }, function (res) {
        if (res.success) {
            $("#taskId").val(res.task.id);
            $("#taskTitulo").val(res.task.titulo);
            $("#taskDescricao").val(res.task.descricao);
            $("#taskData").val(res.task.data_limite);

            $(".modal-title").text("Editar tarefa");
            $("#modalTask").modal("show");
        }
    });
}

// Abre modal de exclusão
function abrirModalDelete(id) {
    $("#delete_id").val(id);
    $("#modalDelete").modal("show");
}
