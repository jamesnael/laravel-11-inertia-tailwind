<template>
    <small>(Drag image if you wish to add images)</small>
    <section
        v-if="editor"
        class="buttons flex items-center flex-wrap gap-x-4 border-l-2 border-t-2 border-r-2 border-gray-400 text-gray-700"
    >
        <template v-if="fontstyleonly">
            <!-- font style -->
            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :disabled="!editor.can().chain().focus().toggleBold().run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('bold'),
                    'p-1': true,
                }"
            >
                <BoldIcon title="Bold" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :disabled="!editor.can().chain().focus().toggleItalic().run()"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('italic'),
                    'p-1': true,
                }"
            >
                <ItalicIcon title="Italic" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
                :disabled="
                    !editor.can().chain().focus().toggleUnderline().run()
                "
                :class="{
                    'bg-gray-200 rounded': editor.isActive('underline'),
                    'p-1': true,
                }"
            >
                <UnderlineIcon title="Underline" />
            </button>

            <button
                type="button"
                @click="fontColorPrompt = true"
            >
                <FormatColorTextIcon title="Format Color Text" />
            </button>
        </template>
        <template v-else>
            <!-- font style -->
            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :disabled="!editor.can().chain().focus().toggleBold().run()||is_code"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('bold'),
                    'p-1': true,
                    'disabled:cursor-not-allowed disabled:text-gray-200 ': true
                }"
            >
                <BoldIcon title="Bold" />
            </button>

            <button
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :disabled="!editor.can().chain().focus().toggleItalic().run()||is_code"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('italic'),
                    'p-1': true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <ItalicIcon title="Italic" />
            </button>

            <button
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
                :disabled="
                    !editor.can().chain().focus().toggleUnderline().run()
                    ||is_code
                "
                :class="{
                    'bg-gray-200 rounded': editor.isActive('underline'),
                    'p-1': true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <UnderlineIcon title="Underline" />
            </button>

            <button
                type="button"
                @click="fontColorPrompt = true"
                :disabled="is_code"
                :class="{
                     'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <FormatColorTextIcon title="Format Color Text" />
            </button>

            <!-- Link -->
            <button
                @click="setLink($event)"
                :disabled="is_code"
                :class="{ 
                    'is-active': editor.isActive('link'),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true 
                }"
            >
                <LinkIcon title="Link" />
            </button>

            <!-- Formatting -->
            <button
                type="button"
                v-if="!tableonly"
                @click="editor.chain().focus().toggleBulletList().run()"
                :disabled="is_code"
                :class="{
                    'p-1': true,
                    'bg-gray-200 rounded': editor.isActive('bulletList'),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <BulletIcon title="Bullet List" />
            </button>
            <button
                type="button"
                v-if="!tableonly"
                @click="editor.chain().focus().toggleOrderedList().run()"
                :disabled="is_code"
                :class="{
                    'p-1': true,
                    'bg-gray-200 rounded': editor.isActive('orderedList'),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <NumberIcon title="Numbered List" />
            </button>
            <button
                type="button"
                v-if="!tableonly"
                @click="editor.chain().focus().toggleBlockquote().run()"
                :disabled="is_code"
                :class="{
                    'p-1': true,
                    'bg-gray-200 rounded': editor.isActive('blockquote'),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <QuoteIcon title="Blockquote" />
            </button>
            <button
                type="button"
                v-if="!tableonly"
                :disabled="is_code"
                @click="editor.chain().focus().setHorizontalRule().run()"
                :class="{
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <HRIcon title="Horizontal Rule" />
            </button>

            <!-- Text Aligns -->
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('left').run()"
                :disabled="is_code"
                :class="{
                    'p-1': true,
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'left',
                    }),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <AlignLeftIcon title="Text Align Left" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('center').run()"
                :disabled="is_code"
                :class="{
                    'p-1': true,
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'center',
                    }),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <AlignCenterIcon title="Text Align Center" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('right').run()"
                :disabled="is_code"
                :class="{
                    'p-1': true,
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'right',
                    }),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <AlignRightIcon title="Text Align Right" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().setTextAlign('justify').run()"
                :disabled="is_code"
                :class="{
                    'p-1': true,
                    'bg-gray-200 rounded': editor.isActive({
                        textAlign: 'justify',
                    }),
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <AlignJustifyIcon title="Text Align Justify" />
            </button>

            <!-- Headings -->
            <button
                type="button"
                v-if="!tableonly && !h3only"
                @click="
                    editor.chain().focus().toggleHeading({ level: 1 }).run()
                "
                :disabled="is_code"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 1,
                    }),
                    'p-1': true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <H1Icon title="Heading 1" />
            </button>
            <button
                type="button"
                v-if="!tableonly && !h3only"
                @click="
                    editor.chain().focus().toggleHeading({ level: 2 }).run()
                "
                :disabled="is_code"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 2,
                    }),
                    'p-1': true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <H2Icon title="Heading 2" />
            </button>
            <button
                type="button"
                v-if="!tableonly"
                @click="
                    editor.chain().focus().toggleHeading({ level: 3 }).run()
                "
                :disabled="is_code"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 3,
                    }),
                    'p-1': true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <H3Icon title="Heading 3" />
            </button>

            <button
                type="button"
                v-if="!tableonly"
                @click="
                    editor.chain().focus().toggleHeading({ level: 4 }).run()
                "
                :disabled="is_code"
                :class="{
                    'bg-gray-200 rounded': editor.isActive('heading', {
                        level: 3,
                    }),
                    'p-1': true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <H4Icon title="Heading 4" />
            </button>

            <!-- Table -->
            <button type="button" @click="tablePrompt = true" 
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }">
                <TableIcon title="Insert Table" />
            </button>
            <button
                type="button"
                @click="editor.commands.addColumnAfter()"
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <TableColumnAfterIcon title="Add Column After" />
            </button>
            <button
                type="button"
                @click="editor.commands.addColumnBefore()"
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <TableColumnBeforeIcon title="Add Column Before" />
            </button>
            <button
                type="button"
                @click="editor.commands.deleteColumn()"
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <TableColumnRemoveIcon title="Delete Column" />
            </button>
            <button
                type="button"
                @click="editor.commands.addRowAfter()"
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <TableRowAfterIcon title="Add Row After" />
            </button>
            <button
                type="button"
                @click="editor.commands.addRowBefore()"
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <TableRowBeforeIcon title="Add Row Before" />
            </button>
            <button
                type="button"
                @click="editor.commands.deleteRow()"
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <TableRowRemoveIcon title="Delete Row" />
            </button>
            <button
                type="button"
                @click="editor.commands.mergeCells()"
                :disabled="is_code"
                :class="{
                    'p-1':true,
                    'disabled:cursor-not-allowed disabled:text-gray-200': true
                }"
            >
                <TableMergeCellsIcon title="Merge Cells" />
            </button>

            <!-- Actions -->
            <button
                type="button"
                @click="editor.chain().focus().undo().run()"
                :disabled="!editor.can().chain().focus().undo().run()||is_code"
                :class="{
                    'p-1':true,
                    'disabled:text-gray-400':true
                }"
            >
                <UndoIcon title="Undo" />
            </button>
            <button
                type="button"
                :class="{
                    'p-1':true,
                    'disabled:text-gray-400':true
                }"
                @click="editor.chain().focus().redo().run()"
                :disabled="!editor.can().chain().focus().redo().run()||is_code"
            >
                <RedoIcon title="Redo" />
            </button>

            <button
                type="button"
                v-if="!tableonly"
                @click="
                    is_code == false ? is_code = true : is_code = false,openCode()
                "
                :class="{
                    'bg-gray-200 rounded': is_code == true,
                    'p-1': true,
                }"
            >
                <CodeTags title="Source Button" />
            </button>
        </template>
    </section>

    <!-- Editor Instance -->
    <editor-content v-if="!is_code" :editor="editor" />

    <div v-if="is_code">
        <textarea
            rows="5"
            :class="{
                'w-full focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:text-gray-100': true,
            }"
            v-model="sourceCode"
            @change="changeSourceCode($event)"
        />
    </div>

    <!-- Create Table Prompt -->
    <dialog-modal :show="tablePrompt" @close="tablePrompt = false">
        <div class="flex flex-col space-y-6 p-10 items-center">
            <div class="flex flex-row gap-2">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Number of Rows
                        <span class="text-red-400">*</span></span
                    >
                    <input
                        type="text"
                        class="rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:text-gray-100"
                        v-model="tableRows"
                        @keypress="isNumber($event)"
                    />
                </div>
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium"
                        >Number of Column
                        <span class="text-red-400">*</span></span
                    >
                    <input
                        type="text"
                        class="rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:text-gray-100"
                        v-model="tableCells"
                        @keypress="isNumber($event)"
                    />
                </div>
            </div>
            <div class="w-full pt-5">
                <div class="flex flex-row justify-center space-x-4">
                    <button
                        type="button"
                        class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                        @click.prevent="tablePrompt = false"
                    >
                        Cancel
                    </button>
                    <button
                        :disabled="
                            (tableRows == '' && tableCells == '') ||
                            (tableRows == 0 && tableCells == 0)
                        "
                        type="button"
                        class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed"
                        @click.prevent="createTable()"
                    >
                        Create Table
                    </button>
                </div>
            </div>
        </div>
    </dialog-modal>

    <!-- Font Color Prompt -->
    <dialog-modal :show="fontColorPrompt" @close="fontColorPrompt = false">
        <div class="flex flex-col space-y-6 p-10 items-center">
            <div class="flex flex-row gap-2">
                <div class="flex-1 flex flex-col space-y-2">
                    <span class="text-black font-medium">
                        Insert Hex Color <small>(leave blank to reset the color)</small>
                    </span>
                    <input
                        type="text"
                        class="rounded-md focus:ring-1 ring-indigo-500 placeholder-gray-500 text-black disabled:cursor-not-allowed disabled:text-gray-100"
                        v-model="fontColor"
                    />
                </div>
            </div>
            <div class="w-full pt-5">
                <div class="flex flex-row justify-center space-x-4">
                    <button
                        type="button"
                        class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:cursor-not-allowed"
                        @click.prevent="fontColorPrompt = false"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="py-3 px-6 text-center shadow-md rounded-md font-semibold text-white bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-300 disabled:cursor-not-allowed"
                        @click.prevent="changeFontColor()"
                    >
                        Change Color
                    </button>
                </div>
            </div>
        </div>
    </dialog-modal>
</template>

<script>
import DialogModal from "@/Components/Modal/DialogModal.vue";

// Tiptap and its Extensions
import StarterKit from "@tiptap/starter-kit";
import { Editor, EditorContent } from "@tiptap/vue-3";
import Underline from "@tiptap/extension-underline";
import Table from "@tiptap/extension-table";
import TableRow from "@tiptap/extension-table-row";
import TableCell from "@tiptap/extension-table-cell";
import TableHeader from "@tiptap/extension-table-header";
import TextAlign from "@tiptap/extension-text-align";
import ImageExtension from "@tiptap/extension-image";
import { MyImage } from "./TiptapExtensions/image";
import Link from "@tiptap/extension-link";
import { Color } from "@tiptap/extension-color";
import Text from "@tiptap/extension-text";
import TextStyle from "@tiptap/extension-text-style";

// Icons
import BoldIcon from "vue-material-design-icons/FormatBold.vue";
import ItalicIcon from "vue-material-design-icons/FormatItalic.vue";
import UnderlineIcon from "vue-material-design-icons/FormatUnderline.vue";
import BulletIcon from "vue-material-design-icons/FormatListBulleted.vue";
import NumberIcon from "vue-material-design-icons/FormatListNumbered.vue";
import QuoteIcon from "vue-material-design-icons/FormatQuoteClose.vue";
import HRIcon from "vue-material-design-icons/Minus.vue";
import UndoIcon from "vue-material-design-icons/Undo.vue";
import RedoIcon from "vue-material-design-icons/Redo.vue";
import H1Icon from "vue-material-design-icons/FormatHeader1.vue";
import H2Icon from "vue-material-design-icons/FormatHeader2.vue";
import H3Icon from "vue-material-design-icons/FormatHeader3.vue";
import H4Icon from "vue-material-design-icons/FormatHeader4.vue";
import TableIcon from "vue-material-design-icons/TablePlus.vue";
import TableColumnAfterIcon from "vue-material-design-icons/TableColumnPlusAfter.vue";
import TableColumnBeforeIcon from "vue-material-design-icons/TableColumnPlusBefore.vue";
import TableColumnRemoveIcon from "vue-material-design-icons/TableColumnRemove.vue";
import TableRowAfterIcon from "vue-material-design-icons/TableRowPlusAfter.vue";
import TableRowBeforeIcon from "vue-material-design-icons/TableRowPlusBefore.vue";
import TableRowRemoveIcon from "vue-material-design-icons/TableRowRemove.vue";
import TableMergeCellsIcon from "vue-material-design-icons/TableMergeCells.vue";
import AlignLeftIcon from "vue-material-design-icons/FormatAlignLeft.vue";
import AlignRightIcon from "vue-material-design-icons/FormatAlignRight.vue";
import AlignCenterIcon from "vue-material-design-icons/FormatAlignCenter.vue";
import AlignJustifyIcon from "vue-material-design-icons/FormatAlignJustify.vue";
import LinkIcon from "vue-material-design-icons/Link.vue";
import FormatColorTextIcon from "vue-material-design-icons/FormatColorText.vue";
import CodeTags from "vue-material-design-icons/CodeTags.vue";

export default {
    components: {
        DialogModal,
        EditorContent,
        BoldIcon,
        ItalicIcon,
        UnderlineIcon,
        BulletIcon,
        NumberIcon,
        QuoteIcon,
        HRIcon,
        UndoIcon,
        RedoIcon,
        H1Icon,
        H2Icon,
        H3Icon,
        H4Icon,
        TableIcon,
        TableColumnAfterIcon,
        TableColumnBeforeIcon,
        TableColumnRemoveIcon,
        TableRowAfterIcon,
        TableRowBeforeIcon,
        TableRowRemoveIcon,
        TableMergeCellsIcon,
        AlignLeftIcon,
        AlignRightIcon,
        AlignCenterIcon,
        AlignJustifyIcon,
        LinkIcon,
        FormatColorTextIcon,
        CodeTags
    },

    props: {
        modelValue: {
            type: String,
            default: "",
        },
        tableonly: {
            type: Boolean,
            default: false,
        },
        fontstyleonly: {
            type: Boolean,
            default: false,
        },
        h3only: {
            type: Boolean,
            default: false,
        },
    },

    emits: ["update:modelValue"],

    data() {
        return {
            editor: null,
            tablePrompt: false,
            tableRows: "",
            tableCells: "",
            fontColorPrompt: false,
            fontColor: "",
            sourceCode:'',
            is_code: false
        };
    },

    watch: {
        modelValue(value) {
            // this.sourceCode = value;

            // HTML
            const isSame = this.editor.getHTML() === value;

            // JSON
            // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

            if (isSame) {
                return;
            }
            this.editor.commands.setContent(value, false);
        },
        // sourceCode(value) {
        //     // HTML
        //     const isSame = this.editor.getHTML() === value;

        //     if (isSame) {
        //         return;
        //     }
        //     this.editor.commands.setContent(value, false);
        // }
    },

    mounted() {
        this.editor = new Editor({
            extensions: [
                StarterKit,
                Underline,
                Table.configure({
                    resizable: true,
                }),
                TableRow,
                TableCell,
                TableHeader,
                TextAlign.configure({
                    types: ["paragraph", "heading", "image"],
                    alignments: ["left", "center", "right", "justify"],
                }),
                ImageExtension,
                MyImage,
                Link.configure({
                    HTMLAttributes: {
                        class: "reference-link",
                        openOnClick: true,
                    },
                }),
                Text,
                TextStyle,
                Color,
            ],
            content: this.modelValue,
            editorProps: {
                attributes: {
                    class: "min-h-[8rem] border-2 border-gray-400 outline-none prose max-w-none",
                },
                handleDrop: function (view, event, slice, moved) {
                    // check if any external files is dropped
                    if (
                        !moved &&
                        event.dataTransfer.files &&
                        event.dataTransfer.files[0]
                    ) {
                        const file = event.dataTransfer.files[0];
                        const filesize = (file.size / 1024 / 1024).toFixed(4); // get the filesize in MB
                        const maxSize = 3;

                        if (
                            (file.type === "image/jpeg" ||
                                file.type === "image/png") &&
                            filesize <= maxSize
                        ) {
                            let _URL = window.URL || window.webkitURL;
                            let img = new Image();
                            img.src = _URL.createObjectURL(file);

                            // load image
                            img.onload = function () {
                                // upload image
                                const data = new FormData();
                                data.append("file", file);
                                axios
                                    .post(
                                        route("text-editor.store-image"),
                                        data
                                    )
                                    .then(({ data }) => {
                                        // return image url
                                        const { schema } = view.state;
                                        const coordinate = view.posAtCoords({
                                            left: event.clientX,
                                            top: event.clientY,
                                        });
                                        const node = schema.nodes.image.create({
                                            src: data.url,
                                        }); // create image element
                                        const transaction =
                                            view.state.tr.insert(
                                                coordinate.pos,
                                                node
                                            ); // place image in the correct positio

                                        return view.dispatch(transaction);
                                    })
                                    .catch((err) => {
                                        console.log(err);
                                        alert(
                                            "There was a problem uploading your image, please try again."
                                        );
                                    });
                            };
                        } else {
                            alert(
                                `The allowed filetypes are jpg and png with max size of ${maxSize}MB!!`
                            );
                        }
                        return true;
                    }
                    return false;
                },
            },
            onUpdate: () => {
                // HTML
                this.$emit("update:modelValue", this.editor.getHTML());

                // JSON
                // this.$emit('update:modelValue', this.editor.getJSON())
            },
        });

        this.sourceCode = this.editor.getHTML();
    },

    beforeUnmount() {
        this.editor.destroy();
    },
    methods: {
        changeSourceCode(event) {
            this.editor.commands.setContent(event.target.value, false);
            this.$emit("update:modelValue", this.editor.getHTML());
        },
        openCode() {
            this.sourceCode = this.modelValue;
        },
        isNumber: function (evt) {
            evt = evt ? evt : window.event;
            let charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode > 31 &&
                (charCode < 48 || charCode > 57) &&
                charCode !== 46
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        createTable() {
            this.editor.commands.insertTable({
                rows: this.tableRows,
                cols: this.tableCells,
            });

            this.tablePrompt = false;
            this.tableRows = "";
            this.tableCells = "";
        },
        setLink(evt) {
            evt.preventDefault();
            const previousUrl = this.editor.getAttributes("link").href;
            const url = window.prompt("URL", previousUrl);

            // cancelled
            if (url === null) {
                return;
            }

            // empty
            if (url === "") {
                this.editor
                    .chain()
                    .focus()
                    .extendMarkRange("link")
                    .unsetLink()
                    .run();

                return;
            }

            // update link
            this.editor
                .chain()
                .focus()
                .extendMarkRange("link")
                .setLink({ href: url, target: "_blank" })
                .run();

            return true;
        },
        changeFontColor() {
            if (this.fontColor != '') {
                this.editor.chain().focus().setColor(this.fontColor).run();
            } else {
                this.editor.chain().focus().unsetColor().run();
            }

            this.fontColorPrompt = false;
            this.fontColor = "";
            return true;
        }
    },
};
</script>

<style>
.tiptap table {
    border: 1px solid red;
}
.tiptap table th {
    border: 1px solid black;
}
.tiptap table td {
    border: 1px solid black;
    padding-left: 0;
}

.tiptap img {
    display: inline !important;
    height: auto !important;
    max-width: 50%;
}

.ProseMirror-selectednode img {
    outline: 3px solid #3b82f6;
    cursor: pointer;
}

.ProseMirror.resize-cursor {
    cursor: ew-resize !important;
    cursor: col-resize !important;
}

.ProseMirror tbody td {
    padding-left: 5px !important;
}
</style>
<!-- By Andre R, 2023 -->
