<template>
    <div>
        <div class="form-group">
            <label for="csv_file">CSV file to import</label>
            <div class="col-sm-9">
                <input type="file" id="csv_file" name="csv_file" @change="loadCSV($event)" />
            </div>
        </div>
        <div class="col-sm-offset-3 col-sm-9">
            <button href="#" class="btn btn-success"  v-if="isFileExists" v-on:click="uploadData">Upload</button>
        </div>
        <table v-if="parse_csv">
            <thead>
                <tr>
                    <th v-for="key in parse_header"
                        @click="sortBy(key)"
                        :class="{ active: sortKey == key }">
                        {{ key | capitalize }}
                        <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'"></span>
                    </th>
                </tr>
            </thead>
            <tr v-for="csv in parse_csv">
                <td v-for="key in parse_header">
                    {{csv[key]}}
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        name: "CsvParser",
        data() {
            return {
                channel_name: '',
                channel_fields: [],
                channel_entries: [],
                parse_header: [],
                parse_csv: [],
                sortOrders:{},
                sortKey: ''
            };
        },
        filters: {
            capitalize: function (str) {
                return str.charAt(0).toUpperCase() + str.slice(1)
            }
        },
        computed: {
            isFileExists() {
                return this.parse_csv.length !== 0
            }
        },
        methods: {
            sortBy: function (key) {
                var vm = this
                vm.sortKey = key
                vm.sortOrders[key] = vm.sortOrders[key] * -1
            },
            csvJSON(csv){
                var vm = this
                var lines = csv.split("\n")
                var result = []
                var headers = lines[0].split(",")
                vm.parse_header = lines[0].split(",")
                lines[0].split(",").forEach(function (key) {
                    vm.sortOrders[key] = 1
                })

                lines.map(function(line, indexLine){
                    if (indexLine < 1) return // Jump header line

                    var obj = {}
                    var currentline = line.split(",")

                    headers.map(function(header, indexHeader){
                        obj[header] = currentline[indexHeader]
                    })

                    result.push(obj)
                })

                result.pop() // remove the last item because undefined values

                return result // JavaScript object
            },
            loadCSV(e) {
                var vm = this
                if (window.FileReader) {
                    var reader = new FileReader();
                    reader.readAsText(e.target.files[0]);
                    // Handle errors load
                    reader.onload = function(event) {
                        var csv = event.target.result;
                        vm.parse_csv = vm.csvJSON(csv)

                    };
                    reader.onerror = function(evt) {
                        if(evt.target.error.name == "NotReadableError") {
                            alert("Canno't read file !");
                        }
                    };
                } else {
                    alert('FileReader are not supported in this browser.');
                }
            },
            uploadData() {
                this.$store.dispatch('uploadData', {
                    csv: this.parse_csv
                })
                .then(isSuccess => {
                     if (isSuccess) {
                         this.parse_csv = []
                         this.parse_header = []
                         this.$store.dispatch('fetchUsers', 1)
                     }
                })
            }
        }
    }
</script>

<style scoped>
</style>