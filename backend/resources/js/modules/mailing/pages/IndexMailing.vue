<template>
    <div>
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Mailing</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Mailing</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="modal fade" id="modal-info">
                            <div class="modal-dialog">
                                <div class="modal-content bg-info">
                                    <div class="modal-header">
                                        <h4 class="modal-title">User emails</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p v-for="email in getEmails">
                                            {{ email }}
                                        </p>
                                        <p>
                                            . . .
                                        </p>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-outline-light" data-dismiss="modal">OK</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->

                        </div>
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Compose New Message</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="btn btn-default btn-file">
                                            <i class="fas fa-paperclip"></i> Send to (csv,txt)
                                            <input type="file" name="attachment" v-on:change="uploadFile($event)">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Subject:" v-model="formData.subject">
                                </div>
                                <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" style="height: 300px" v-model="formData.message">
                    </textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-primary" v-on:click="sendMessage"><i class="far fa-envelope"></i> Send</button>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        name: "IndexMailing",
        data() {
            return {
                formData: {
                    subject: null,
                    message: " <h1><u>Heading Of Message</u></h1>\n" +
                            "<h4>Subheading</h4>\n" +
                            " <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain\n" +
                            " was born and I will give you a complete account of the system, and expound the actual teachings\n" +
                            " of the great explorer of the truth, the master-builder of human happiness. No one rejects,\n" +
                            " dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know\n" +
                            " how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again\n" +
                            " is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,\n" +
                            " but because occasionally circumstances occur in which toil and pain can procure him some great\n" +
                            " pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,\n" +
                            " dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so\n" +
                            " blinded by desire, that they cannot foresee</p>\n" +
                            " <ul>\n" +
                            "   <li>List item one</li>\n" +
                            "   <li>List item two</li>\n" +
                            "   <li>List item three</li>\n" +
                            "   <li>List item four</li>\n" +
                            " </ul>\n" +
                            " <p>Thank you,</p>\n" +
                            " <p>John Doe</p>",
                    emails: []
                }
            }
        },
        computed: {
            getEmails() {
                return this.formData.emails.slice(0, 6)
            }
        },
        methods: {
            sendMessage() {
                if(this.isDataValid()) {
                    console.log(this.formData);
                    this.$store.dispatch('sendEmail', this.formData)
                        .then(isSucces => {
                            console.log(isSucces);
                            if(isSucces) {
                                this.formData.emails = [];
                                this.formData.subject = null;
                                this.formData.message =  " <h1><u>Heading Of Message</u></h1>\n" +
                                    "<h4>Subheading</h4>\n" +
                                    " <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain\n" +
                                    " was born and I will give you a complete account of the system, and expound the actual teachings\n" +
                                    " of the great explorer of the truth, the master-builder of human happiness. No one rejects,\n" +
                                    " dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know\n" +
                                    " how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again\n" +
                                    " is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,\n" +
                                    " but because occasionally circumstances occur in which toil and pain can procure him some great\n" +
                                    " pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,\n" +
                                    " dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so\n" +
                                    " blinded by desire, that they cannot foresee</p>\n" +
                                    " <ul>\n" +
                                    "   <li>List item one</li>\n" +
                                    "   <li>List item two</li>\n" +
                                    "   <li>List item three</li>\n" +
                                    "   <li>List item four</li>\n" +
                                    " </ul>\n" +
                                    " <p>Thank you,</p>\n" +
                                    " <p>John Doe</p>";
                            }
                        })
                }
                else {
                    Vue.$toast.open({
                        message: 'Please, fill all fields',
                        type: 'error',
                        position: 'top-right',
                        duration:5000
                    });
                }
            },
            uploadFile(ev) {
                const file = ev.target.files[0];
                const reader = new FileReader();

                reader.onload = e => this.formData.emails = e.target.result.split("\n");
                reader.readAsText(file);
                $('#modal-info').modal('show')
            },
            isDataValid() {
                if (!_.isNull(this.formData.message)
                    && !_.isNull(this.formData.subject)
                    && this.formData.emails.length !== 0
                    && this.formData.message !== ""
                    && this.formData.subject !== "") {
                    return true
                }

                return false
            }
        }
    }
</script>

<style scoped>

</style>