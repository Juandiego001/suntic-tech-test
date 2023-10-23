import PropTypes from 'prop-types';

function Cart ({ products }) {
    return (
        <>
            <h1>Productos</h1>

            {
                products
            }
        </>
    )
}

Cart.propTypes = {
    products: PropTypes.array.isRequired
}

export default Cart