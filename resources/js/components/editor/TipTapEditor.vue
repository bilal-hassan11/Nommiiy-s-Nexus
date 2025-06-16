<template>
  <div class="editor-container">
    <!-- Toolbar -->
    <div class="toolbar">
      <!-- Formatting -->
      <div class="toolbar-group">
        <button @click="toggle('bold')" :class="{ active: isActive('bold') }" title="Bold">
          <Bold class="icon" /> Bold
        </button>
        <button @click="toggle('italic')" :class="{ active: isActive('italic') }" title="Italic">
          <Italic class="icon" /> Italic
        </button>
        <button @click="toggle('underline')" :class="{ active: isActive('underline') }" title="Underline">
          <UnderlineIcon class="icon" /> Underline
        </button>
      </div>

      <div class="vertical-line"></div>

      <!-- Headings -->
      <div class="toolbar-group">
        <button @click="toggleHeading(1)" :class="{ active: isActive('heading', { level: 1 }) }">
          <Heading1 size="20" />
        </button>
        <button @click="toggleHeading(2)" :class="{ active: isActive('heading', { level: 2 }) }">
          <Heading2 size="20" />
        </button>
        <button @click="toggleHeading(3)" :class="{ active: isActive('heading', { level: 3 }) }">
          <Heading3 size="20" />
        </button>
        <button @click="setParagraph" :class="{ active: isActive('paragraph') }">
          <AlignLeft class="icon" /> Paragraph
        </button>
      </div>

      <div class="vertical-line"></div>

      <!-- Lists -->
      <div class="toolbar-group">
        <button @click="toggle('bulletList')" :class="{ active: isActive('bulletList') }">
          <List size="20" />
        </button>
        <button @click="toggle('orderedList')" :class="{ active: isActive('orderedList') }">
          <ListOrdered size="20" />
        </button>
      </div>

      <div class="vertical-line"></div>

      <!-- Text Alignment -->
      <div class="toolbar-group">
        <button @click="setAlign('left')" :class="{ active: isTextAlign('left') }">
          <AlignLeft size="20" />
        </button>
        <button @click="setAlign('center')" :class="{ active: isTextAlign('center') }">
          <AlignCenter size="20" />
        </button>
        <button @click="setAlign('right')" :class="{ active: isTextAlign('right') }">
          <AlignRight size="20" />
        </button>
        <button @click="setAlign('justify')" :class="{ active: isTextAlign('justify') }">
          <AlignJustify size="20" />
        </button>
      </div>
    </div>

    <!-- Editor Content -->
    <EditorContent :editor="editor" class="editor" />
  </div>
</template>

<script setup>
import {watch, onBeforeUnmount} from 'vue'
import {Editor, EditorContent} from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import TextAlign from '@tiptap/extension-text-align'
import Heading from '@tiptap/extension-heading'
import Paragraph from '@tiptap/extension-paragraph'
import BulletList from '@tiptap/extension-bullet-list'
import OrderedList from '@tiptap/extension-ordered-list'
import Underline from '@tiptap/extension-underline'

// Icons
import {Underline as UnderlineIcon} from 'lucide-vue-next'
import {
  Bold, Italic, Heading1, Heading2, Heading3,
  List, ListOrdered, AlignLeft, AlignCenter, AlignRight, AlignJustify
} from 'lucide-vue-next'

// Props
const props = defineProps({
  modelValue: {
    type: String,
    default: '<p>Type here...</p>'
  }
})
const emit = defineEmits(['update:modelValue'])

// Editor instance
const editor = new Editor({
  content: props.modelValue || '<p>Type here...</p>',
  extensions: [
    StarterKit.configure({
      heading: false,
      paragraph: false,
      bulletList: false,
      orderedList: false
    }),
    Heading.configure({levels: [1, 2, 3]}),
    Paragraph,
    BulletList,
    OrderedList,
    Underline,
    TextAlign.configure({types: ['heading', 'paragraph']})
  ],
  onUpdate({editor}) {
    emit('update:modelValue', editor.getHTML())
  }
})

// Utilities
const toggle = (cmd) => editor.chain().focus()[`toggle${capitalize(cmd)}`]().run()
const toggleHeading = (level) => editor.chain().focus().toggleHeading({level}).run()
const setAlign = (alignment) => editor.chain().focus().setTextAlign(alignment).run()
const setParagraph = () => editor.chain().focus().setParagraph().run()
const isActive = (cmd, opts = {}) => editor.isActive(cmd, opts)
const isTextAlign = (alignment) => editor.isActive({textAlign: alignment})

function capitalize(str) {
  return str.charAt(0).toUpperCase() + str.slice(1)
}

// Sync external modelValue to editor content
watch(() => props.modelValue, (newVal) => {
  if (editor && editor.getHTML() !== newVal) {
    editor.commands.setContent(newVal || '<p>Type here...</p>')
  }
})

// Cleanup
onBeforeUnmount(() => {
  if (editor) editor.destroy()
})
</script>

<style scoped>
.editor-container {
  font-family: system-ui, sans-serif;
}

.toolbar {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
  background: #ffffff;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.06);
}

.toolbar-group {
  display: flex;
  gap: 6px;
}

button {
  background-color: #f9f9f9;
  border: 1px solid #dcdcdc;
  border-radius: 5px;
  padding: 6px 10px;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 14px;
  color: #333;
  cursor: pointer;
  transition: all 0.2s ease;
}

button:hover {
  background-color: #eef4ff;
  border-color: #a3c2ff;
}

button.active {
  background-color: #cce0ff;
  border-color: #5599ff;
  font-weight: bold;
}

.icon {
  width: 16px;
  height: 16px;
}

.editor {
  border: 1px solid #ccc;
  border-radius: 6px;
  min-height: 300px;
  padding: 16px;
  background-color: #fff;
  font-size: 15px;
  line-height: 1.6;
}

.vertical-line {
  width: 1px;
  height: 24px;
  background-color: #a8a8a8;
  margin: 0 8px;
}
</style>
