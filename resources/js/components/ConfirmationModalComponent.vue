<template>
    <div>
        <button class="btn btn-sm btn-danger" title="Удалить" data-toggle="modal" :data-target="selector">
            <i class="fas fa-times-circle"></i>
        </button>
        <div :id="calculateId" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Подтверждение удаления</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span class="text-danger">ВНИМАНИЕ!</span>
                        <span>Вы действительно хотите удалить запись &laquo;{{ entity_name }}&raquo;? Это действие необратимо.</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <form method="post" :action="action">
                            <csrf-field></csrf-field>
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // Компонент модального окна подтверждения удаления
    export default {
        // Свойства
        props: {
            // ID
            id: Number,
            // Название удаляемой записи
            entity_name: String,
            // Адрес отправки формы удаления
            action: String
        },
        name: "ConfirmationModalComponent",
        // Методы
        computed: {
            // Генерирует ID модального окна удаления
            calculateId: function() {
                return "deleteConfirmationId"+this.id;
            },
            // Селектор для модального окна
            selector: function () {
                return "#"+this.calculateId;
            }
        }
    }
</script>
