package testlaythongtinmay;

/**
 * Constants - Sử dụng Config để lấy giá trị từ environment
 * Không hardcode credentials
 */
public class Constants {
    // Sử dụng Config thay vì hardcode
    public static final String API_BASE_URL = Config.getApiBaseUrl();
    
    public static final String API_LOGIN = Config.getApiLogin();
    public static final String API_REGISTER = Config.getApiRegister();
    public static final String API_CHECK_TOKEN = Config.getApiCheckToken();
    public static final String API_XEM_DETAI = Config.getApiXemDetai();
    public static final String API_XEM_DSDIEM = Config.getApiXemDsDiem();
    public static final String API_NHAP_DIEM = Config.getApiNhapDiem();
    public static final String API_GET_DETAI_GV = Config.getApiGetDetaiGV();
    public static final String API_GET_SV_THEO_DETAI = Config.getApiGetSVTheoDeTai();
}
