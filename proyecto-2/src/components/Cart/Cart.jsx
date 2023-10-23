import PropTypes from 'prop-types';
import Card from '../Card/Card';

function Cart ({ products, addProductToCurrent }) {
    return (
        <>
            <h1 className="pt-5 text-center">Productos</h1>

            <p>
                Has registrado un total de: {products.length} productos
            </p>

            {
              products.map((item, index) => {
                return (
                <Card
                    addProductToCurrent={addProductToCurrent}
                    title={item.title}
                    description={item.description}
                    price={item.price}
                    url={item.url}
                    key={index} />)
              })
            }
        </>
    )
}

Cart.propTypes = {
    addProductToCurrent: PropTypes.func.isRequired,
    products: PropTypes.array.isRequired
}

export default Cart