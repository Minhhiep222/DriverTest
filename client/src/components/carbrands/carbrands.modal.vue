<template>
  <div>
    <a-modal
      :open="visible"
      title="Tùy chỉnh hãng xe"
      @ok="handleOk"
      @cancel="handleCancel"
      ok-text="Lưu"
      cancel-text="Hủy"
      :bodyStyle="{ maxHeight: '80vh', overflowY: 'auto' }"
    >
      <div>
        <a-input
          placeholder="Nhập tên hãng xe và nhấn Enter"
          @keyup.enter="addBrand"
        />
        <div style="margin-top: 16px">
          <a-tag
            v-for="(brand, index) in carBrands.arr"
            :key="brand.id || index"
            closable
            @close="removeBrand(index, brand.id)"
          >
            {{ brand.name }}
          </a-tag>
        </div>
      </div>
    </a-modal>
  </div>
</template>

<script lang="ts" setup>
import carBrandsAPI from '@/apiRequest/car-brands'
import { ref, watch } from 'vue'

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

const carBrands = ref({ arr: [] })

// Fetch initial car brands
watch(
  () => props.visible,
  async (newVisible) => {
    if (newVisible) {
      const res = await carBrandsAPI.getUserCarBrands()
      carBrands.value.arr = res.payload as []
    }
  },
)
// Add a new car brand
const addBrand = (e) => {
  const name = e.target.value.trim()
  if (name && !carBrands.value.arr.some((brand) => brand.name === name)) {
    carBrands.value.arr.push({ id: null, name })
    e.target.value = ''
  }
}

// Remove a car brand
const removeBrand = async (index, id) => {
  if (id) {
    await carBrandsAPI.deleteCarBrand(id)
    props.reloadSelect()
  }
  carBrands.value.arr.splice(index, 1)
}

// Save car brands
const handleOk = async () => {
  const newBrands = carBrands.value.arr.filter((brand) => !brand.id)
  if (newBrands.length) {
    const names = newBrands.map((brand) => {
      return brand.name
    })
    await carBrandsAPI.addCarBrands({ names: names })

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
