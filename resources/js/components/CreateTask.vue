<template>
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createTaskModalLabel">Nowe zadanie</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="title" class="col-form-label">Nazwa zadania</label>
              <input type="text" class="form-control" v-model="fields.title">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Opis zadania</label>
              <textarea class="form-control" id="message-text" v-model="fields.description"></textarea>
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Przewidywany termin realizacji</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Dodaj</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>
</template>

 <script>
     export default {
        data() {
            return {
                categories: null,
                fields: {},
                success: false,
                errors: {}
            }
        },
        mounted() {
            
        },
        methods: {
            submit() {
                axios.post('/api/tasks', this.fields).then(response => {
                    this.fields = {};
                    this.success = true;
                    this.errors = {};
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    console.log('Error');
                });
            }
        }
    }
    </script>