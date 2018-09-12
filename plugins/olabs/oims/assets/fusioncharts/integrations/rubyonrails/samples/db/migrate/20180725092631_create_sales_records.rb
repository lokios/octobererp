class CreateSalesRecords < ActiveRecord::Migration[5.2]
  def change
    create_table :sales_records do |t|
      t.string :Region
      t.string :Country
      t.string :City
      t.integer :TotalSales

      t.timestamps
    end
  end
end
