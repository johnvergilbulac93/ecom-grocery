<template>
    <div class="container">
        <div class="mt-2">
            <label for="description"
                >Upload file to update item description.</label
            >
            <div>
                <Upload
                    multiple
                    type="drag"
                    action="/api/upload/item_description"
                    :headers="{
                        'x-csrf-token': token,
                        'X-Requested-With': 'XMLHttpRequest'
                    }"
                    :on-success="handleSuccess"
                    :on-error="handleError"
                    :before-upload="handleBeforeUpload"
                >
                    <div style="padding: 20px 0">
                        <Icon
                            type="ios-cloud-upload"
                            size="300"
                            style="color: orange"
                        ></Icon>
                        <p>Click or drag files here</p>
                    </div>
                </Upload>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            token: null,
        };
    },
    methods: {
        handleSuccess() {
            this.loading = false;
            swal.fire("Success", "Upload Complete.", "success");
            $("#uploadItem").modal("hide");
            $("#uploadUom").modal("hide");
            $("#uploadPrice").modal("hide");
            $("#uploadCategory").modal("hide");
        },
        handleError(res, file) {
            this.loading = false;
            swal.fire(
                "Warning",
                `${
                    file.errors.file.length
                        ? file.errors.file[0]
                        : "Something went wrong!"
                }`,
                "warning"
            );
        },
        handleBeforeUpload(e) {
            this.loading = true;
        }
    },
    created() {
        this.token = $("meta[name=csrf-token]").attr("content");
        // this.countUOM();
    }
};
</script>
<style scoped>
.demo-spin-icon-load {
    animation: ani-demo-spin 1s linear infinite;
}
@keyframes ani-demo-spin {
    from {
        transform: rotate(0deg);
    }
    50% {
        transform: rotate(180deg);
    }
    to {
        transform: rotate(360deg);
    }
}
.demo-spin-col {
    right: 294px;
}
</style>
