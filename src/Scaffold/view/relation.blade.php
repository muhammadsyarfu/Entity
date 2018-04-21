<script type="text/x-template" id="tttRelation">
    <table class="table table-striped table-bordered">
        <caption>
            <h3>Relation</h3>
        </caption>
        <thead>
        <tr>
            <th width="50px"></th>
            <th>Function Name</th>
            <th>Type</th>
            <th>Model</th>
            <th>Pivot Table</th>
            <th>Foreign Key</th>
            <th>Other Key</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="relation in model.relation.list">
            <td>
                <button v-on:click="remove(relation)" class="btn btn-danger" type="button">X</button>
            </td>
            <td><input v-model="relation.name" class="form-control" type="text"></td>
            <td><select v-model="relation.type" class="form-control">
                    <option value="belongsTo">belongsTo</option>
                    <option value="belongsToMany">belongsToMany</option>
                    <option value="hasOne">hasOne</option>
                    <option value="hasMany">hasMany</option>
                </select></td>
            <td>
                <button v-on:click="selectModel(relation)" class="btn btn-default">@brace('relation.model')</button>
            </td>
            <td>
                <span v-on:click="selectPivot(relation)" class="btn btn-default">@brace('relation.pivotTable ? relation.pivotTable : "+"')</span>
            </td>
            <td>
                <span v-on:click="selectForeign(relation)" class="btn btn-default">@brace('relation.foreignKey ? relation.foreignKey : "+"')</span>
            </td>
            <td>
                <span v-on:click="selectOther(relation)" class="btn btn-default">@brace('relation.otherKey ? relation.otherKey : "+"')</span>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <button v-on:click="add" class="btn btn-primary" type="button">+</button>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-relation', {
        template: '#tttRelation',
        props: ['model'],
        methods: {
            add: function () {
                let relation = this.model.relation;
                let data = {
                    message: 'Select the Model',
                    display: 'name',
                    array: vd.project.entity.list,
                    callback: function (yes, entity) {
                        if (yes) {
                            relation.create(entity.name, 'belongsTo');
                        }
                    }
                };
                showChoose(data);
            },
            remove: function (relation) {
                if (sure('Are you sure?')) {
                    this.model.relation.remove(relation);
                }
            },
            selectModel: function (relation) {
                let data = {
                    message: 'Select the Model',
                    display: 'name',
                    array: vd.project.entity.list,
                    callback: function (yes, entity) {
                        if (yes) {
                            relation.model = entity.model.name;
                        }
                    }
                };
                showChoose(data);
            },
            selectPivot: function (relation) {
                let data = {
                    message: 'Select the Pivot Table',
                    display: 'name',
                    array: vd.project.entity.list,
                    callback: function (yes, entity) {
                        if (yes) {
                            relation.pivotTable = entity.table.name;
                            relation.pivot = entity;
                        }
                    }
                };
                showChoose(data);
            },
            selectForeign: function (relation) {
                let list = this.model.table.field.list;
                if (relation.pivot) {
                    list = relation.pivot.table.field.list;
                }
                let data = {
                    message: 'Select the Foreign Key',
                    display: 'name',
                    array: list,
                    callback: function (yes, field) {
                        if (yes) {
                            relation.foreignKey = field.name;
                        }
                    }
                };
                showChoose(data);
            },
            selectOther: function (relation) {
                if (null == relation.pivot) {
                    look('Please select a Pivot table first!');
                    return;
                }
                let data = {
                    message: 'Select the Other Key',
                    display: 'name',
                    array: relation.pivot.table.field.list,
                    callback: function (yes, field) {
                        if (yes) {
                            relation.otherKey = field.name;
                        }
                    }
                };
                showChoose(data);
            }
        }
    });

</script>
