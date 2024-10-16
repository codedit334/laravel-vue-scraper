<template>
    <div class="card">
        <img :src="imageSrc" alt="Card Image" />
        <div class="card-content">
            <div class="card-title" :title="title">{{ truncatedTitle }}</div>
            <div class="card-address">📍 {{ address }}</div>
            <div class="card-footer">
                <div class="price">
                    <span class="starting-from">À partir de </span>
                    <span class="price-amount">{{ price }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    imageSrc: String,
    title: String,
    address: String,
    price: String
  },
  computed: {
    truncatedTitle() {
      if (this.title.length > 35) {
        return this.title.slice(0, 35) + '...';
      }
      return this.title;
    },
  },
}
</script>

<style scoped>
.card {
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card-content {
    padding: 16px;
}

.card-title {
    font-size: 14.5px;
    font-weight: bold;
    margin-bottom: 12px;
    text-align: left; /* Title starts from the left */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
    cursor: pointer;
}

.card-title:hover {
  text-decoration: underline;
  position: relative;
}

.card-title:hover::after {
  content: attr(title); /* Shows full title on hover */
  position: absolute;
  bottom: 100%;
  left: 0;
  background-color: rgba(0, 0, 0, 0.8);
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  white-space: nowrap;
  font-size: 12px;
  z-index: 10;
}

.card-address {
    font-size: 14.5px;
    margin-bottom: 12px;
    text-align: left; /* Title starts from the left */
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.price {
    font-size: 12px;
    font-weight: bold;
}

.starting-from {
    color: black; /* 'A partir de' in black */
}

.price-amount {
    color: #0056b3; /* New shade of blue for the price */
}

.button {
    background-color: #007bff;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    font-size: 14px;
    cursor: pointer;
}

.button:hover {
    background-color: #0056b3;
}
</style>
