import PropTypes from 'prop-types';

function Card ({ addProductToCurrent,
    addProductToCart, title, description, price, url }) {
    return (
        <>
            <div className="card shadow-sm mb-4">
              <div className="mx-auto w-50">
                <img src={url} className="card-img-top img-thumbnail" />
              </div>
            <div className="card-body">
                <h2>{title}</h2>
                <p className="card-text">
                    Descripción: {description}
                </p>
                <h4>
                    Precio: $ {price}
                </h4>
              <div className="d-flex justify-content-between align-items-center">
                <div className="btn-group">
                  {
                    typeof addProductToCurrent !== "function" ?
                      <button type="button" className="btn btn-sm btn-primary"
                        onClick={() => addProductToCart({ title, description, price, url })}>
                        Agregar al carrito
                      </button>
                    :
                      <button type="button" className="btn btn-sm btn-danger"
                        onClick={() => addProductToCurrent({ title, description, price, url })}>
                        Quitar del carrito
                      </button>
                  }
                </div>
              </div>
            </div>
          </div>
        </>
    )
}

Card.propTypes = {
    addProductToCurrent: PropTypes.func,
    addProductToCart: PropTypes.func,
    title: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
    price: PropTypes.number.isRequired,
    url: PropTypes.string.isRequired
}

export default Card
