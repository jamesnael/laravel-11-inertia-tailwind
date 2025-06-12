import ImageExtension from "@tiptap/extension-image";
import { mergeAttributes } from "@tiptap/core";

export const MyImage = ImageExtension.extend({
    defaultOptions: {
        ...ImageExtension.options,
        sizes: ["inline", "block", "left", "right"],
    },
    renderHTML(html) {
        const { HTMLAttributes } = html;
        const style = HTMLAttributes.style;

        return [
            "figure",
            { style },
            [
                "img",
                mergeAttributes(this.options.HTMLAttributes, HTMLAttributes),
            ],
        ];
    },
});
