import { useState } from 'react'
import Card from './components/Card/Card'
import Cart from './components/Cart/Cart'

function App() {

  const [cartProducts, setCartProducts] = useState([]);

  const [products, setProducts] = useState([
    {
      title: 'Camara',
      description: 'Camara HD',
      price: 3000000,
      url: "https://www.canon.com.au/-/media/images/canon/products/mirrorless-cameras/eos-r5-temp/tile-image-eosr5-1200x1200.ashx?mw=1200&hash=D6E43B947B880336BEDF0ED8C29FA0BC"
    },
    {
      title: 'Teléfono iPhone',
      description: 'Teléfono iPhone 10',
      price: 1800000,
      url: "https://www.losdistribuidores.com/wp-content/uploads/2022/09/iPhone-14-purpura.webp"
    },
    {
      title: 'Playstation 5',
      description: 'PLaystation 5 con Gran Thef Auto 6',
      price: 20000000,
      url: "https://cosonyb2c.vtexassets.com/arquivos/ids/357735/PS5_BNDL_EAFC24_GMEDLC_DLC_RNDR_LT_PROD_RGB_LA_230728.jpg?v=638312437878770000"
    }
  ]);

  function addProductToCurrent (product) {
    const currentProducts = [...products];
    currentProducts.push(product);
    setProducts(currentProducts);
    removeProduct(product);
  }

  function removeProductCurrent (product) {
    let currentProducts = [...products];
    currentProducts = currentProducts.filter(
      item => item.title != product.title);
    setProducts(currentProducts);
  }

  function addProductToCart (product) {
    const currentProducts = [...cartProducts];
    currentProducts.push(product);
    setCartProducts(currentProducts);
    removeProductCurrent(product);
  }

  function removeProduct (product) {
    let currentProducts = [...cartProducts];
    console.log('PRIMERO' , currentProducts);
    currentProducts = currentProducts.filter(
      item => item.title != product.title);
    console.log('SEGUNDO' , currentProducts);
    setCartProducts(currentProducts);
  }

  return (
    <>
      <div className="bg-secondary text-white row w-100 m-0 p-0 py-4">
        <div className="col col-lg-6">
          <h1 className="pt-5 text-center">Productos de la tienda</h1>
          <p>Estos son los productos de la tienda.</p>
          {
            products.map((item, index) => {
              return (
                <Card addProductToCart={addProductToCart}
                  title={item.title}
                  description={item.description}
                  price={item.price}
                  url={item.url}
                  key={index} />)
            })
          }
        </div>

        <div className="col col-lg-6">
          <Cart products={cartProducts}
            addProductToCurrent={addProductToCurrent}/>
        </div>
      </div>
    </>
  )
}

export default App
