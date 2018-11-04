@extends('spark::layouts.app')
@section('content')
<organisation :user="user" inline-template>
<div>
    <!-- Organisations -->
    <div class="panel  panel-content panel-default">
        <div class="panel-heading">Organisation Contacts</div>
        <div class="panel-body">
            <button type="button" class="btn btn-primary"
                @click.prevent="showContactModal">
                Add organisation
            </button>
            <table class="table table-borderless m-b-none" v-show="contacts.length > 0">
                <thead>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th class="samerow">Operations</th>
                </thead>
                <tbody>
                    <tr v-for="contact in contacts">
                        <!-- Name -->
                        <td>
                            <div class="btn-table-align">
                                @{{ contact.name }}
                            </div>
                        </td>
                        
                        <td>
                            <div class="btn-table-align">
                                @{{ contact.phone }}
                            </div>
                        </td>
                        <td>
                            <div class="btn-table-align">
                                @{{ contact.email }}
                            </div>
                        </td>
                        <td>
                            <div class="btn-table-align">
                                @{{ contact.address }}
                            </div>
                        </td>
                        <!-- Delete Button -->
                        <td>
                            <button class="btn btn-danger" @click="deleteContact(contact)">
                                <i class="fa fa-trash-o"></i>
                            </button>
                            <button type="submit" class="btn btn-primary"
                                @click.prevent="editContact(contact)"
                                :disabled="form.busy">
                                Edit
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Create/Update Contact Modal -->
    <div class="modal fade" id="modal-update-contact" tabindex="-1" role="dialog">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">
                        Add/Edit organisation
                    </h4>
                </div>

                <div class="modal-body">
                    <!-- Update Contact Form -->
                    
                    <form  role="form" @submit.prevent="">
                        <!-- Name -->
                        
                            <div class="form-group" :class="{'has-error': form.errors.has('name')}">
                                <label class="control-label">Name</label>
                                <input type="text" class="form-control" name="name" v-model="form.name">
                                <span class="help-block" v-show="form.errors.has('name')">
                                    @{{ form.errors.get('name') }}
                                </span>
                            </div>
                            <div class="form-group" :class="{'has-error': form.errors.has('phone')}">
                                <label class="control-label">Phone</label>
                                <input type="text" class="form-control" name="phone" v-model="form.phone">
                                <span class="help-block" v-show="form.errors.has('phone')">
                                    @{{ form.errors.get('phone') }}
                                </span>
                            </div>
                            <div class="form-group" :class="{'has-error': form.errors.has('email')}">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" v-model="form.email">
                                <span class="help-block" v-show="form.errors.has('email')">
                                    @{{ form.errors.get('email') }}
                                </span>
                            </div>
                            <div class="form-group" :class="{'has-error': form.errors.has('address')}">
                                <label class="control-label">Address</label>
                                <input type="text" class="form-control" name="address" v-model="form.address">
                                <span class="help-block" v-show="form.errors.has('address')">
                                    @{{ form.errors.get('address') }}
                                </span>
                            </div>
                            <div class="form-group" :class="{'has-error': form.errors.has('website')}">
                                <label class="control-label">Website</label>
                                <input type="text" class="form-control" name="website" v-model="form.website">
                                <span class="help-block" v-show="form.errors.has('website')">
                                    @{{ form.errors.get('website') }}
                                </span>
                            </div>
                      
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                            @click.prevent="createContact"
                            :disabled="form.busy" v-if="create">
                        Create
                    </button>
                    <button type="button" class="btn btn-primary"
                            @click.prevent="updateContact(contact)"
                            :disabled="form.busy" v-else>
                        Update
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
</organisation>
@endsection