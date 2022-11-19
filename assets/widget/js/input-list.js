class InputListWidget {

    constructor({widgetId, name, label}) {
        this.widgetId = widgetId;
        this.name = name;
        this.label = label;
    }

    init() {
        let self = this;
        const input = $(`#${self.widgetId} input[name="input"]`),
            addBtn = $(`#${self.widgetId} .btn-add`),
            listContainer = $(`#${self.widgetId} .list-container`);

        const generateHtml = (data) => {
            data = data ? data: input.val();
            const result = data ? data.trim(): '';

            if(result) {
                listContainer.prepend(
                    `<div class="input-group mb-2">
                        <input placeholder="Enter a ${self.label}" type="text" class="form-control" name="${self.name}" value="${result}">
                        <div class="input-group-append">
                            <button class="btn btn-danger btn-icon btn-remove" type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>`
                );
                input.val('').focus();
            }
        };

        input.on('keydown', (e) => {
            if(e.key == 'Enter') {
                e.preventDefault();
                generateHtml();
            }
        });

        addBtn.on('click', () => {
            generateHtml();
        });

        $(document).on('click', `#${self.widgetId} .btn-remove`, function() {
            $(this).closest('.input-group').remove();
        });
    }
}

