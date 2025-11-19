$(document).ready(function () {
    carregarTarefas();

    // Salvar tarefa (criar + editar)
    $("#formTask").on("submit", function (e) {
        e.preventDefault();

        let id = $("#taskId").val();
        let action = id ? "controllers/task_edit.php" : "controllers/task_create.php";

        $.post(action, $(this).serialize(), function (res) {
            if (res.success) {
                $("#modalTask").modal("hide");
                carregarTarefas();
            } else {
                alert(res.message);
            }
        });
    });
});

function carregarTarefas(page = 1) {
    $.get("controllers/task_list.php", { page }, function (res) {
        if (!res.success) return;

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
                    <button class="btn btn-sm btn-danger" onclick="deletar(${t.id})">Excluir</button>
                </div>
            </div>
            `;
        });

        $("#tasksList").html(html);
    });
}

function toggleTask(id) {
    $.post("controllers/task_toggle.php", { id }, function (res) {
        if (res.success) carregarTarefas();
    });
}

function deletar(id) {
    if (!confirm("Confirmar exclusão?")) return;

    $.post("controllers/task_delete.php", { id }, function (res) {
        if (res.success) carregarTarefas();
    });
}

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
