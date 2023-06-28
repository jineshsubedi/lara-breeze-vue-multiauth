<script>
import jsPDF from "jspdf";

export default {
    components: {},
    props: {
        changeFile: { type: Function },
        description: String,
    },
    emits: ["update:changeFile"],
    data: () => {
        return {
            pdfFile: null,
        };
    },
    methods: {
        downloadPDF() {
            const pdf = new jsPDF("p", "pt", "a4");
            const margins = {
                top: 80,
                bottom: 60,
                left: 40,
                width: 522,
            };
            pdf.fromHTML(
                this.description,
                margins.left,
                margins.right,
                {
                    width: margins.width, // max width of content on PDF
                },
                function (bla) {
                    pdf.save("letter_download.pdf");
                },
                margins
            );
        },
    },
};
</script>
<template>
    <div v-if="this.description != ''">
        <button
            type="submit"
            class="btn btn-sm btn-outline-success"
            @click="downloadPDF"
        >
            Download PDF
        </button>
    </div>
</template>
