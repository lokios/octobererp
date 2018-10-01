require 'test_helper'

class SamplesControllerTest < ActionDispatch::IntegrationTest
  test "should get index" do
    get samples_index_url
    assert_response :success
  end

end
