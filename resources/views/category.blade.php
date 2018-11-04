@extends('spark::layouts.app')

@section('content')
<category :user="user" inline-template>
<div >
    <!-- Current categories -->
    <div class="panel panel-content panel-default">
        <div class="panel-heading">Categories
        </div>

        <div class="panel-body">
        <small>While creating appointment you can set appointment category from one of the following categories. You can also add new category.</small>
        <br>
        <button type="button" class="btn btn-primary"
                @click.prevent="showModal">
            Add category
        </button>
            <table class="table table-borderless m-b-none" v-show="categories.length > 0">
                <thead>
                    <th>Name</th>
                    <th></th>
                </thead>

                <tbody>
                    <tr v-for="category in categories">
                        <!-- Name -->
                        <td>
                            <div class="btn-table-align">
                                @{{ category.name }}
                            </div>
                        </td>

                        <!-- Delete Button -->
                        <td>
                            <button class="btn btn-danger" @click="deleteCategory(category)">
                                <i class="fa fa-trash-o"></i>
                            </button>
                            <button type="submit" class="btn btn-primary"
                                    @click.prevent="editCategory(category)"
                                    :disabled="form.busy">
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
        <!-- Create/Update Category Modal -->
    <div class="modal fade" id="modal-update-category" tabindex="-1" role="dialog">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">
                        Add/Edit category
                    </h4>
                </div>

                <div class="modal-body">
                    <!-- Update Team Member Form -->
                    <form  @submit.prevent="" role="form">
                        <!-- Name -->
                        <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                            <label class="control-label">Name</label>
                            <input type="text" class="form-control" name="name" v-model="form.name">
                            <span class="help-block" v-show="form.errors.has('name')">
                                @{{ form.errors.get('name') }}
                            </span>
                        </div>
                            
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                            @click.prevent="createCategory"
                            :disabled="form.busy" v-if="create">
                        Create
                    </button>
                    <button type="button" class="btn btn-primary"
                            @click.prevent="updateCategory(category)"
                            :disabled="form.busy" v-else>
                        Update
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
</category>
@endsection
