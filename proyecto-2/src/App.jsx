import { useState } from 'react'
import Card from './components/Card/Card'
import Cart from './components/Cart/Cart'

function App() {

  const [cartProducts, setCartProducts] = useState([]);

  const products = [
    {
      title: 'Camara',
      description: 'Camara HD',
      price: 20000,
      url: "https://www.canon.com.au/-/media/images/canon/products/mirrorless-cameras/eos-r5-temp/tile-image-eosr5-1200x1200.ashx?mw=1200&hash=D6E43B947B880336BEDF0ED8C29FA0BC"
    },
    {
      title: 'Camara',
      description: 'Camara HD',
      price: 20000,
      url: "https://www.canon.com.au/-/media/images/canon/products/mirrorless-cameras/eos-r5-temp/tile-image-eosr5-1200x1200.ashx?mw=1200&hash=D6E43B947B880336BEDF0ED8C29FA0BC"
    },
    {
      title: 'Camara',
      description: 'Camara HD',
      price: 20000,
      url: "https://www.canon.com.au/-/media/images/canon/products/mirrorless-cameras/eos-r5-temp/tile-image-eosr5-1200x1200.ashx?mw=1200&hash=D6E43B947B880336BEDF0ED8C29FA0BC"
    }
  ];

  return (
    <>
      <div className="row w-100 m-0 p-0 py-4">
        <div className="col col-lg-6">
          {
            products.map((item, index) => {
              return (<Card title={item.title} description={item.description}
                price={item.price} url={item.url} key={index} />)
            })
          }
        </div>

        <div className="col col-lg-6">
          <Cart products={cartProducts} />
        </div>
      </div>
    </>
  )
}

export default App
