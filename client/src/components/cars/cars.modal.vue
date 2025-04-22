<template>
  <div>
    <a-modal
      :open="visible"
      title="Tùy chỉnh dòng xe"
      @ok="handleOk"
      @cancel="handleCancel"
      ok-text="Lưu"
      cancel-text="Hủy"
      :bodyStyle="{ maxHeight: '80vh', overflowY: 'auto' }"
    >
      <div>
        <a-input
          placeholder="Nhập tên xe và nhấn Enter"
          @keyup.enter="addCar"
        />
        <div style="margin-top: 16px">
          <a-tag
            v-for="(car, index) in cars.arr"
            :key="car.id || index"
            closable
            @close="removeCar(index, car.id)"
          >
            {{ car.name }}
          </a-tag>
        </div>
      </div>
    </a-modal>
  </div>
</template>

<script lang="ts" setup>
import carsAPI from '@/apiRequest/cars'
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

const cars = ref({ arr: [] })

// Fetch initial car brands

watch(
  () => props.visible,
  async (newVisible) => {
    if (newVisible) {
      const res = await carsAPI.getUserCars()
      cars.value.arr = res.payload as []
    }
  },
)
// Add a new car brand
const addCar = (e) => {
  const name = e.target.value.trim()
  if (name && !cars.value.arr.some((car) => car.name === name)) {
    cars.value.arr.push({ id: null, name })
    e.target.value = ''
  }
}

// Remove a car brand
const removeCar = async (index, id) => {
  if (id) {
    await carsAPI.deleteCar(id)
    props.reloadSelect()
  }
  cars.value.arr.splice(index, 1)
}

// Save car brands
const handleOk = async () => {
  const newCars = cars.value.arr.filter((car) => !car.id)
  if (newCars.length) {
    const names = newCars.map((brand) => {
      return brand.name
    })
    await carsAPI.addCars({ names: names })

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
