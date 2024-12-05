import React, { useEffect, useState } from "react";
import { Table, Spinner, Alert, Form, Button, Pagination, Modal } from "react-bootstrap";
import { apiKey } from "../api";

const PurchaseHistory = ({ userReferenceId }) => {
  const [purchaseHistory, setPurchaseHistory] = useState([]);
  const [filteredHistory, setFilteredHistory] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [searchTerm, setSearchTerm] = useState("");
  const [currentPage, setCurrentPage] = useState(1);
  const [showModal, setShowModal] = useState(false);
  const [selectedPurchase, setSelectedPurchase] = useState(null);
  const itemsPerPage = 5;

  useEffect(() => {
    const fetchPurchaseHistory = async () => {
      setLoading(true);
      setError(null);

      const url = `https://api.gameshift.dev/nx/payments`;
      const options = {
        method: "GET",
        headers: {
          accept: "application/json",
          "x-api-key": apiKey,
        },
      };

      try {
        const response = await fetch(url, options);
        if (!response.ok) {
          throw new Error("Không thể tải lịch sử mua hàng.");
        }
        const data = await response.json();

        // Lọc dữ liệu dựa trên userReferenceId
        const filteredData = data.data.filter(
          (payment) => payment.purchaser.referenceId === userReferenceId
        );
        setPurchaseHistory(filteredData);
        setFilteredHistory(filteredData);
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    if (userReferenceId) {
      fetchPurchaseHistory();
    }
  }, [userReferenceId]);

  // Xử lý tìm kiếm
  useEffect(() => {
    const filtered = purchaseHistory.filter((purchase) =>
      purchase.sku.item.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    setFilteredHistory(filtered);
    setCurrentPage(1); // Reset về trang đầu khi tìm kiếm
  }, [searchTerm, purchaseHistory]);

  // Tính toán số trang
  const totalPages = Math.ceil(filteredHistory.length / itemsPerPage);
  const currentItems = filteredHistory.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

  const handlePageChange = (pageNumber) => {
    setCurrentPage(pageNumber);
  };

  const handleViewDetails = (purchase) => {
    setSelectedPurchase(purchase);
    setShowModal(true);
  };

  const handleCloseModal = () => {
    setShowModal(false);
    setSelectedPurchase(null);
  };

  return (
    <div className="purchase-history">
      <h3>Lịch sử Mua Hàng</h3>

      {loading ? (
        <div className="text-center">
          <Spinner animation="border" variant="primary" />
          <p>Đang tải...</p>
        </div>
      ) : error ? (
        <Alert variant="danger">{error}</Alert>
      ) : (
        <>
          <div className="d-flex justify-content-between align-items-center mb-3">
            <Form.Control
              type="text"
              placeholder="Tìm kiếm sản phẩm..."
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
              style={{ maxWidth: "300px" }}
            />
          </div>

          {filteredHistory.length === 0 ? (
            <Alert variant="warning">Không có lịch sử mua hàng.</Alert>
          ) : (
            <>
              <Table striped bordered hover responsive>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Số tiền</th>
                    <th>Ngày giao dịch</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  {currentItems.map((purchase, index) => (
                    <tr key={purchase.id}>
                      <td>{(currentPage - 1) * itemsPerPage + index + 1}</td>
                      <td>
                        <img
                          src={purchase.sku.item.imageUrl}
                          alt={purchase.sku.item.name}
                          style={{
                            width: "50px",
                            height: "50px",
                            objectFit: "cover",
                            borderRadius: "5px",
                          }}
                        />
                      </td>
                      <td>{purchase.sku.item.name}</td>
                      <td>{purchase.price.naturalAmount.toLocaleString()} USDC</td>
                      <td>{new Date(purchase.timestamp).toLocaleString()}</td>
                      <td>
                        <span
                          className={`badge ${
                            purchase.status === "Completed"
                              ? "bg-success"
                              : purchase.status === "Pending"
                              ? "bg-warning"
                              : purchase.status === "Expired"
                              ? "bg-danger"
                              : "bg-secondary"
                          }`}
                        >
                          {purchase.status}
                        </span>
                      </td>
                      <td>
                        <Button
                          variant="primary"
                          size="sm"
                          onClick={() => handleViewDetails(purchase)}
                        >
                          Xem chi tiết
                        </Button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </Table>

              <Pagination>
                {[...Array(totalPages)].map((_, index) => (
                  <Pagination.Item
                    key={index}
                    active={index + 1 === currentPage}
                    onClick={() => handlePageChange(index + 1)}
                  >
                    {index + 1}
                  </Pagination.Item>
                ))}
              </Pagination>
            </>
          )}
        </>
      )}

      {/* Modal chi tiết */}
      {selectedPurchase && (
        <Modal show={showModal} onHide={handleCloseModal} centered>
          <Modal.Header closeButton>
            <Modal.Title>Chi tiết giao dịch</Modal.Title>
          </Modal.Header>
          <Modal.Body>
            <div className="text-center">
              <img
                src={selectedPurchase.sku.item.imageUrl}
                alt={selectedPurchase.sku.item.name}
                style={{
                  width: "150px",
                  height: "150px",
                  objectFit: "cover",
                  borderRadius: "8px",
                }}
              />
            </div>
            <p><strong>Sản phẩm:</strong> {selectedPurchase.sku.item.name}</p>
            <p><strong>Số tiền:</strong> {selectedPurchase.price.naturalAmount.toLocaleString()} USDC</p>
            <p><strong>Ngày giao dịch:</strong> {new Date(selectedPurchase.timestamp).toLocaleString()}</p>
            <p><strong>Trạng thái:</strong> {selectedPurchase.status}</p>
            <p><strong>Mô tả:</strong> {selectedPurchase.sku.item.description}</p>
          </Modal.Body>
          <Modal.Footer>
            <Button variant="secondary" onClick={handleCloseModal}>
              Đóng
            </Button>
          </Modal.Footer>
        </Modal>
      )}
    </div>
  );
};

export default PurchaseHistory;
