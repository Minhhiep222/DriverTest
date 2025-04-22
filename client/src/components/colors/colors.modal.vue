<template>
  <div>
    <a-modal
      :open="visible"
      title="Tùy chỉnh màu xe"
      @ok="handleOk"
      @cancel="handleCancel"
      ok-text="Lưu"
      cancel-text="Hủy"
      :bodyStyle="{ maxHeight: '80vh', overflowY: 'auto' }"
    >
      <div>
        <a-input
          placeholder="Nhập màu xe và nhấn Enter"
          @keyup.enter="addColor"
        />
        <div style="margin-top: 16px">
          <a-tag
            v-for="(brand, index) in colors.arr"
            :key="brand.id || index"
            closable
            @close="removeColor(index, brand.id)"
          >
            {{ brand.name }}
          </a-tag>
        </div>
      </div>
    </a-modal>
  </div>
</template>

<script lang="ts" setup>
import colorAPI from '@/apiRequest/color'
import { onMounted, ref } from 'vue'

const props = defineProps({
  visible: {
    type: Boolean,
    required: true,
  },
  reloadSelect: {
    type: Function,
    required: true,
  },
})

const emit = defineEmits(['update:visible'])

const colors = ref({ arr: [] })

// Fetch initial car brands
onMounted(async () => {
  const res = await colorAPI.getUserColor()
  colors.value.arr = res.payload as []
})

// Add a new car brand
const addColor = (e) => {
  const name = e.target.value.trim()
  if (name && !colors.value.arr.some((brand) => brand.name === name)) {
    colors.value.arr.push({ id: null, name })
    e.target.value = ''
  }
}

// Remove a car brand
const removeColor = async (index, id) => {
  if (id) {
    await colorAPI.deleteColor(id)
    props.reloadSelect()
  }
  colors.value.arr.splice(index, 1)
}

// Save car brands
const handleOk = async () => {
  const newColors = colors.value.arr.filter((color) => !color.id)
  if (newColors.length) {
    const names = newColors.map((brand) => {
      return brand.name
    })
    await colorAPI.addColors({ names: names })

    props.reloadSelect()
    emit('update:visible', false)
  }
}

// Cancel modal
const handleCancel = () => {
  props.reloadSelect()
  emit('update:visible', false)
}
</script>
