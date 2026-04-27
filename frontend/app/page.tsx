"use client";
import { useEffect, useState } from "react";
import styles from "./style.module.css";


type Cliente = {
  id: number;
  nome: string;
  email: string;
};

type ApiResponse = {
  success: boolean;
  message: string;
};

export default function Home() {
  const [clientes, setClientes] = useState<Cliente[]>([]);
  const [nome, setNome] = useState("");
  const [email, setEmail] = useState("");
  const [id, setId] = useState<string>("");

  const [mensagem, setMensagem] = useState<string>("");
  const [erro, setErro] = useState<boolean>(false);

  const API_URL = "http://localhost:8000/index.php";

  const fetchClientes = async () => {
    try {
      const res = await fetch(API_URL);
      const data = await res.json();
      setClientes(data);
    } catch (err) {
      setMensagem("Erro ao buscar clientes");
      setErro(true);
    }
  };

  const handleResponse = async (res: Response) => {
    if (res.ok) {
      // limpa inputs se a resposta for bem-sucedida 
      setId("");
      setNome("");
      setEmail("");
    }

    try {
      const data: ApiResponse = await res.json();
      setMensagem(data.message);
      setErro(!data.success);
    } catch {
      setMensagem("Erro inesperado na resposta do servidor");
      setErro(true);
    }
  };

  const criarCliente = async () => {
    const res = await fetch(API_URL, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ nome, email }),
    });

    await handleResponse(res); 
    
    fetchClientes()
  };

  const deletarCliente = async () => {
    const res = await fetch(API_URL, {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id }),
    });

    await handleResponse(res);   
    
    fetchClientes()
  };

  const atualizarCliente = async () => {
    const res = await fetch(API_URL, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, nome, email }),
    });

    await handleResponse(res);    

    fetchClientes()
  };

  useEffect(() => {
    fetchClientes();
  }, []);

  return (
    <div className={styles.container}>
      <h1 className={styles.title}>CRUD de Clientes</h1>

      {mensagem && (
        <div
          className={styles.alert}
          style={{
            backgroundColor: erro ? "#ff4d4f" : "#52c41a",
          }}
        >
          {mensagem}
        </div>
      )}

      <div className={styles.grid}>
        {/* Criar */}
        <div className={styles.card}>
          <h2>Criar Cliente</h2>
          <input
            className={styles.input}
            value={nome}
            placeholder="Nome"
            onChange={(e) => setNome(e.target.value)}
          />
          <input
            className={styles.input}
            value={email}
            placeholder="Email"
            onChange={(e) => setEmail(e.target.value)}
          />
          <button 
            className={styles.button} 
            onClick={criarCliente}>
            Criar
          </button>
        </div>

        {/* Atualizar */}
        <div className={styles.card}>
          <h2>Atualizar Cliente</h2>
          <input
            className={styles.input}
            value={id}
            placeholder="ID"
            onChange={(e) => {
              const value = e.target.value;

              // só permite dígitos
              if (/^\d*$/.test(value)) {
                setId(value);
              }
            }}
          />
          <input
            className={styles.input}
            value={nome}
            placeholder="Nome"
            onChange={(e) => setNome(e.target.value)}
          />
          <input
            className={styles.input}
            value={email}
            placeholder="Email"
            onChange={(e) => setEmail(e.target.value)}
          />
          <button className={styles.button} onClick={atualizarCliente}>
            Atualizar
          </button>
        </div>

        {/* Deletar */}
        <div className={styles.card}>
          <h2>Deletar Cliente</h2>
          <input
            className={styles.input}
            value={id}
            placeholder="ID"
            onChange={(e) => {
              const value = e.target.value;

              // só permite dígitos
              if (/^\d*$/.test(value)) {
                setId(value);
              }
            }}
          />
          <button 
            className={styles.button} 
            style={{ backgroundColor: "#ff4d4f" }} 
            onClick={deletarCliente}>
            Deletar
          </button>
        </div>
      </div>

      {/* Lista */}
      <div className={styles.listContainer}>
        <p className={ `${styles.title} ${styles.p1}` }>Lista de Clientes</p>
        <table className={styles.table}>
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            {clientes.map((c) => (
              <tr key={c.id}>
                <td className={styles.centered}>{c.id}</td>
                <td>{c.nome}</td>
                <td>{c.email}</td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
};