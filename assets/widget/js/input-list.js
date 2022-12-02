class InputListWidget {

    constructor({widgetId, name, label, type}) {
        this.widgetId = widgetId;
        this.name = name;
        this.label = label;
        this.type = type
    }

    init() {
        let self = this;
        const input =  $(`#${self.widgetId} ${self.type}[name="input"]`),
            addBtn = $(`#${self.widgetId} .btn-add`),
            listContainer = $(`#${self.widgetId} .list-container`);

        const generateHtml = (data) => {
            data = data ? data: input.val();
            const result = data ? data.trim(): '';

            if(result) {
                if (self.type == 'input') {
                    listContainer.append(
                        `<div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <button class="btn btn-secondary handle-sortable" type="button">
                                    <i class="fas fa-arrows-alt"></i>
                                </button>
                            </div>
                            <input placeholder="Enter a ${self.label}" type="text" class="form-control" name="${self.name}" value="${result}">
                            <div class="input-group-append">
                                <button class="btn btn-danger btn-remove" type="button">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>`
                    );
                }
                else if(self.type == 'textarea') {
                    listContainer.append(
                        `<div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <button class="btn btn-secondary handle-sortable" type="button">
                                    <i class="fas fa-arrows-alt"></i>
                                </button>
                            </div>
                            <textarea placeholder="Enter a ${self.label}" type="text" class="form-control" name="${self.name}">${result}</textarea>
                            <div class="input-group-append">
                                <button class="btn btn-danger btn-remove" type="button">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>`
                    );
                }
                input.val('').focus();
            }
        };

        input.on('keydown', (e) => {
            if(e.key == 'Enter') {
                if (self.type == 'input') {
                    e.preventDefault();
                    generateHtml();
                }
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

