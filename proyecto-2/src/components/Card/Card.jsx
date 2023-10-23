import PropTypes from 'prop-types';

function Card ({ title, description, price, url }) {
    return (
        <>
            <div className="card shadow-sm mb-4">
            <img src={url} className="card-img-top" width="100%" height="225" />
            <div className="card-body">
                <h2>{title}</h2>
                <p className="card-text">
                    {description}
                </p>
                <h4>
                    {price}
                </h4>
              <div className="d-flex justify-content-between align-items-center">
                <div className="btn-group">
                  <button type="button" className="btn btn-sm btn-primary">Agregar al carrito</button>
                </div>
              </div>
            </div>
          </div>
        </>
    )
}

Card.propTypes = {
    title: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
    price: PropTypes.number.isRequired,
    url: PropTypes.string.isRequired
}

export default Card
