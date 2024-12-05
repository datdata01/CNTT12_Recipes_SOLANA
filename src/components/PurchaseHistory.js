import React, { useEffect, useState } from "react";
import { Alert, Table, Spinner, Modal, Button } from "react-bootstrap";

const PurchaseHistory = ({ userId }) => {
  const [purchaseHistory, setPurchaseHistory] = useState([]);
  const [isLoading, setIsLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showModal, setShowModal] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);

  useEffect(() => {
    const fetchPurchaseHistory = async () => {
      try {
        setIsLoading(true);
        setError(null);

        const response = await fetch(
          `https://api.example.com/users/${userId}/purchase-history`
        );

        if (!response.ok) {
          throw new Error(
            `Không thể lấy dữ liệu: ${response.status} - ${response.statusText}`
          );
        }

        const data = await response.json();
        console.log("Dữ liệu trả về từ API:", data);  // Kiểm tra dữ liệu trả về

        setPurchaseHistory(data.purchases || []);  // Đảm bảo API trả về "purchases" là mảng
      } catch (err) {
        setError("Không thể lấy dữ liệu từ API: " + err.message);
      } finally {
        setIsLoading(false);
      }
    };

    if (userId) {
      fetchPurchaseHistory();
    }
  }, [userId]);

  const handleShowDetails = (item) => {
    setSelectedItem(item);
    setShowModal(true);
  };

  const handleCloseModal = () => {
    setShowModal(false);
    setSelectedItem(null);
  };

  return (
    <div>
      <h2 className="mb-4 theme-text">Lịch sử mua hàng</h2>

      {isLoading && (
        <div className="text-center">
          <Spinner animation="border" role="status">
            <span className="visually-hidden">Loading...</span>
          </Spinner>
        </div>
      )}

      {error && (
        <Alert variant="danger" className="mt-3">
          {error}
        </Alert>
      )}

      {!isLoading && !error && purchaseHistory.length === 0 && (
        <Alert variant="warning" className="mt-3">
          Bạn chưa mua sản phẩm nào.
        </Alert>
      )}

      {!isLoading && !error && purchaseHistory.length > 0 && (
        <Table bordered hover responsive className="mt-4">
          <thead>
            <tr>
              <th>#</th>
              <th>Hình ảnh</th>
              <th>Tên sản phẩm</th>
              <th>Giá</th>
              <th>Ngày mua</th>
              <th>Chi tiết</th>
            </tr>
          </thead>
          <tbody>
            {purchaseHistory.map((item, index) => {
              console.log("Item in purchaseHistory:", item);  // Kiểm tra từng sản phẩm
              return (
                <tr key={item.id}>
                  <td>{index + 1}</td>
                  <td>
                    <img
                      src={item.imageUrl}
                      alt={item.name}
                      style={{ maxWidth: "80px", maxHeight: "80px" }}
                      className="img-fluid rounded"
                    />
                  </td>
                  <td>{item.name}</td>
                  <td>{item.price.toLocaleString()} VND</td>
                  <td>{new Date(item.purchaseDate).toLocaleDateString()}</td>
                  <td>
                    <Button
                      variant="primary"
                      size="sm"
                      onClick={() => handleShowDetails(item)}
                    >
                      Xem chi tiết
                    </Button>
                  </td>
                </tr>
              );
            })}
          </tbody>
        </Table>
      )}

      <Modal show={showModal} onHide={handleCloseModal}>
        <Modal.Header closeButton>
          <Modal.Title>Chi tiết sản phẩm</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {selectedItem && (
            <div>
              <div className="text-center mb-3">
                <img
                  src={selectedItem.imageUrl}
                  alt={selectedItem.name}
                  style={{ maxWidth: "100%", maxHeight: "300px" }}
                  className="img-fluid rounded"
                />
              </div>
              <h5>{selectedItem.name}</h5>
              <p>Giá: {selectedItem.price.toLocaleString()} VND</p>
              <p>Ngày mua: {new Date(selectedItem.purchaseDate).toLocaleDateString()}</p>
              <p>Mô tả: {selectedItem.description}</p>
            </div>
          )}
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleCloseModal}>
            Đóng
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
};

export default PurchaseHistory;
