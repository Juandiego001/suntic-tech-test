"""Initial migration

Revision ID: 02242a24fac7
Revises: 
Create Date: 2023-10-20 14:57:59.778290

"""
from alembic import op
import sqlalchemy as sa


# revision identifiers, used by Alembic.
revision = '02242a24fac7'
down_revision = None
branch_labels = None
depends_on = None


def upgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.create_table('informacion',
    sa.Column('codigo', sa.Integer(), autoincrement=True, nullable=False),
    sa.Column('nombrearchivo', sa.String(length=250), nullable=False),
    sa.Column('cantlineas', sa.Integer(), nullable=False),
    sa.Column('cantpalabras', sa.Integer(), nullable=False),
    sa.Column('cantcaracteres', sa.Integer(), nullable=False),
    sa.Column('fecharegistro', sa.Date(), nullable=False),
    sa.PrimaryKeyConstraint('codigo')
    )
    # ### end Alembic commands ###


def downgrade():
    # ### commands auto generated by Alembic - please adjust! ###
    op.drop_table('informacion')
    # ### end Alembic commands ###
